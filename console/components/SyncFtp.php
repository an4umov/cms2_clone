<?php

namespace console\components;

use common\components\helpers\ConsoleHelper;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class SyncFtp
{
    /** @var resource connection var */
    private $conn_id;
    /** @var string host */
    private $ftp_server;
    /** @var string user */
    private $ftp_user_name;
    /** @var string password */
    private $ftp_user_pass;
    /** @var int host server port
     * This parameter specifies an alternate port to connect to.
     * If it is omitted or set to zero, then the default FTP port, 21, will be used.
     */
    private $ftp_port;

    /** @var array of files or directories to ignore
     * under the FTP servers file path
     * uses mb_ereg_match($value, $file)
     * so you can do stuff like this:
     * array(
     *  '/httpdocs.*\/config\.rb',
     *  '/httpdocs/.*\/translations',
     * );
     */
    private $ignore;

    function __construct(
        $ftp_server,
        $ftp_user_name,
        $ftp_user_pass
    ) {
        // initailizing properties
        $this->ftp_server = $ftp_server;
        $this->ftp_user_name = $ftp_user_name;
        $this->ftp_user_pass = $ftp_user_pass;
        $this->ftp_port = 21;

        $this->ignore = [];
    }

    // getter
    function getConn_id()
    {
        return $this->conn_id;
    }

    //setters
    function setFtp_server($ftp_server)
    {
        $this->ftp_server = $ftp_server;
    }

    function setFtp_user_name($ftp_user_name)
    {
        $this->ftp_user_name = $ftp_user_name;
    }

    function setFtp_user_pass($ftp_user_pass)
    {
        $this->ftp_user_pass = $ftp_user_pass;
    }

    /**
     * return false if conn_id defined
     *
     * @param int $ftp_port
     *
     * @return boolean
     */
    function setFtp_port($ftp_port)
    {
        if (!isset($this->conn_id)) {
            $this->ftp_port = $ftp_port;

            return true;
        } else {
            return false;
        }
    }

    function setIgnore($ignore)
    {
        $this->ignore = $ignore;
    }

    function clearIgnore()
    {
        $this->ignore = [];
    }

    /**
     * Starting and checking connection
     */
    function setup($isPassive = true)
    {
        // set up basic connection
        $this->conn_id = ftp_connect($this->ftp_server, $this->ftp_port);

        // login with username and password
        $login_result = ftp_login($this->conn_id, $this->ftp_user_name, $this->ftp_user_pass);

        // check connection
        if ((!$this->conn_id) || (!$login_result)) {
            echo "FTP connection has failed!\n";
            echo "Attempted to connect to $this->ftp_server for user $this->ftp_user_name\n";
            exit;
        } else {
            echo "Connected to $this->ftp_server\n";
        }

        if ($isPassive) {
            ftp_pasv($this->getConn_id(), true);
        }
    }

    /**
     * close the FTP stream
     */
    function close()
    {
        ftp_close($this->conn_id);
    }

    /**
     * @param string  $loc_dir      local directory
     * @param string  $rmt_dir      remote directory
     * @param boolean $isRecursive  will remove found directories as well
     * @param boolean $useWhiteList Ignore array will be used as a white list
     * @param boolean $debug        var_dump( $contents=    ftp_nlist() )
     */
    function ftpGetDir($loc_dir, $rmt_dir, $isRecursive = true, $useWhiteList = false, $debug = false)
    {
        $loc_dir = rtrim($loc_dir, '/');
        $rmt_dir = rtrim($rmt_dir, '/');

        $this->_ftpGetDir($loc_dir, $rmt_dir, $isRecursive, $useWhiteList, $debug);
    }

    /**
     * @param      $localDir
     * @param      $remoteDir
     * @param bool $isRecursive
     * @param bool $useWhiteList
     * @param bool $debug
     */
    private function _ftpGetDir($localDir, $remoteDir, $isRecursive = true, $useWhiteList = false, $debug = false)
    {
        if ($remoteDir != ".") { // if not itself (`.` means current directory)
            if (ftp_chdir($this->conn_id, $remoteDir) == false) {
                ConsoleHelper::debug("[ERROR] Change FTP Dir Failed:". $remoteDir);
                $this->close();
                exit(1);
            }
            if (!(is_dir($localDir))) {
                $rtnmkdir = @mkdir($localDir);
                echo '+/. ' . $localDir . "\n";
                if (!$rtnmkdir) {
                    echo "\nUnknown local path specified...\n";
                    $this->close();
                    exit(1);
                }
            }
            if (chdir($localDir)) {
                ConsoleHelper::debug("Local dir changed to ". $localDir);
            }
        }

        $existsDirs = $existsFiles = [];

        $files = array_diff(scandir($localDir), ['.','..',]);
        foreach ($files as $file) {
            $path = $localDir.DIRECTORY_SEPARATOR.$file;
            if (is_dir($path)) {
                $existsDirs[$file] = $file;
            } else {
                $existsFiles[$file] = $file;
            }
        }

        if ($debug) {
            ConsoleHelper::debug("Local dirs:");
            print_r($existsDirs);

            ConsoleHelper::debug("Local files:");
            print_r($existsFiles);
        }

        $contents = @ftp_nlist($this->conn_id, '.');
        if ($debug) {
            ConsoleHelper::debug("FTP content:");
            print_r($contents);
        }

        foreach ($contents as $ftpFile) {
            if ($ftpFile === '.' || $ftpFile === '..') {
                continue;
            }
            // ignore chosen dirs
            if (!$useWhiteList == ($this->isIgnore($this->ignore, $remoteDir.'/'.$ftpFile))) {
                continue;
            }

            // Directory
            if (@ftp_chdir($this->conn_id, $remoteDir.'/'.$ftpFile)) {
                if (!isset($existsDirs[$ftpFile])) {
                    $rtnmkdir = @mkdir($localDir.DIRECTORY_SEPARATOR.$ftpFile);
                    ConsoleHelper::debug( '+ CREATE DIR '.$localDir.DIRECTORY_SEPARATOR.$ftpFile);
                    if (!$rtnmkdir) {
                        ConsoleHelper::debug("[ERROR] Unable to create local dir: ".$localDir.DIRECTORY_SEPARATOR.$ftpFile);
//                        $this->close();
//                        exit(1);
                    }
                } else {
                    ConsoleHelper::debug('FTP dir '.$remoteDir.'/'.$ftpFile.' exists in local dir');
                    unset($existsDirs[$ftpFile]);
                }

                ftp_chdir($this->conn_id, "..");
                if ($isRecursive) {
                    $this->_ftpGetDir($localDir . DIRECTORY_SEPARATOR . $ftpFile, $remoteDir . '/' . $ftpFile, $isRecursive, $useWhiteList, $debug);
                }
            } else { // File
                if (!isset($existsFiles[$ftpFile])) {
                    $this->_getFtpFile($remoteDir . '/' . urldecode($ftpFile), $localDir . DIRECTORY_SEPARATOR . $ftpFile, true);
                } else {
                    $ftpFileSize = ftp_size($this->conn_id, urldecode($remoteDir . '/' . urldecode($ftpFile)));
                    $localFileSize = filesize($localDir . DIRECTORY_SEPARATOR . $ftpFile);

                    if ($ftpFileSize != -1 && $localFileSize !== false) {
                        if ($ftpFileSize != $localFileSize) {
                            $this->_getFtpFile($remoteDir . '/' . urldecode($ftpFile), $localDir . DIRECTORY_SEPARATOR . $ftpFile, false);
                            ConsoleHelper::debug('Local file size: '.$localFileSize.', ftp file size: '.$ftpFileSize);
                        } else {
                            ConsoleHelper::debug('FTP file '.$remoteDir.'/'.urldecode($ftpFile).' exists in local dir');
                        }
                    } elseif ($ftpFileSize == -1) {
                        ConsoleHelper::debug('[ERROR] Unable to determine FTP file size: '.$remoteDir.'/'.urldecode($ftpFile));
                    } elseif ($localFileSize === false) {
                        ConsoleHelper::debug('[ERROR] Unable to determine local file size: '.$localDir.DIRECTORY_SEPARATOR.$ftpFile);
                    }

                    unset($existsFiles[$ftpFile]);
                }
            }
        }

        if ($existsDirs) {
            if ($debug) {
                echo PHP_EOL;
                ConsoleHelper::debug("Local dirs to DELETE:");
                print_r($existsDirs);
            }


            foreach ($existsDirs as $deleteDir) {
                self::delTree($localDir.DIRECTORY_SEPARATOR.$deleteDir);
            }
        }

        if ($existsFiles) {
            if ($debug) {
                echo PHP_EOL;
                ConsoleHelper::debug("Local files to DELETE:");
                print_r($existsFiles);
            }
/**/
            foreach ($existsFiles as $deleteFile) {
                if (unlink($localDir.DIRECTORY_SEPARATOR.$deleteFile)) {
                    ConsoleHelper::debug('File '.$localDir.DIRECTORY_SEPARATOR.$deleteFile.' deleted');
                } else {
                    ConsoleHelper::debug('[ERROR] Unable to delete '.$localDir.DIRECTORY_SEPARATOR.$deleteFile);
                }
            }

        }

        ftp_chdir($this->conn_id, "..");
        chdir("..");
    }

    /**
     * @param string $ftpFile
     * @param string $localFile
     * @param bool   $isNew
     */
    private function _getFtpFile(string $ftpFile, string $localFile, bool $isNew = false)
    {
        $echo = '+ '.($isNew ? 'CREATE' : 'UPDATE').' FILE '.$localFile.' ';
        $rtnGet = ftp_nb_get(
            $this->conn_id,
            $localFile,
            $ftpFile,
            $this->ftp_trans_mode($ftpFile)
        );

        while ($rtnGet == FTP_MOREDATA) {
            $echo .= '.';
            $rtnGet = ftp_nb_continue($this->conn_id);
        }

        if ($rtnGet != FTP_FINISHED) {
            ConsoleHelper::debug("[ERROR] There was an error downloading the file...");
//            $this->close();
//            exit(1);
        }

        ConsoleHelper::debug($echo);
    }

    /**
     * @param $dir
     *
     * @return bool
     */
    public static function delTree($dir) {
        $files = array_diff(scandir($dir), ['.','..',]);

        foreach ($files as $file) {
            if (is_dir($dir.DIRECTORY_SEPARATOR.$file)) {
                self::delTree($dir.DIRECTORY_SEPARATOR.$file);
            } else {
                if (unlink($dir.DIRECTORY_SEPARATOR.$file)) {
                    ConsoleHelper::debug('File '.$dir.DIRECTORY_SEPARATOR.$file.' deleted');
                } else {
                    ConsoleHelper::debug('[ERROR] Unable to delete '.$dir.DIRECTORY_SEPARATOR.$file);
                }
            }
        }

        if (rmdir($dir)) {
            ConsoleHelper::debug('Directory '.$dir.' deleted');

            return true;
        } else {
            ConsoleHelper::debug('[ERROR] Unable to delete directory '.$dir);
        }

        return false;
    }

    /**
     * finish if needed
     *
     * @param $rmt_dir
     *
     * @return TRUE
     * @return exit(1) if false
     * @see ftpsync::isRmtDir()
     */
    function doesRmtDirExist($rmt_dir)
    {
        if ($this->isRmtDir($rmt_dir) === false) {
            echo "\n"
                . "ERROR 404\n"
                . "Unknown remote path specified...\n";
            $this->close();

            exit(1);
        } else {
            return true;
        }
    }

    /**
     * does remote directory exits?
     *
     * @param $rmt_dir
     *
     * @return boolean
     */
    private function isRmtDir($rmt_dir)
    {
        $rtn_chdir = ftp_chdir($this->conn_id, $rmt_dir);
        if ($rtn_chdir === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * get transfer mode
     *
     * Thanks to:
     * Nate from ruggfamily.com
     * http://php.net/manual/en/function.ftp-get.php#86516
     *
     * @param string $file file name without path
     *
     * @return FTP_BINARY or FTP_ASCII
     */
    function ftp_trans_mode($file)
    {
        $path_parts = pathinfo($file);

        if (!isset($path_parts['extension'])) {
            return FTP_BINARY;
        }
        switch (strtolower($path_parts['extension'])) {
            case 'am':
            case 'asp':
            case 'bat':
            case 'c':
            case 'cfm':
            case 'cgi':
            case 'conf':
            case 'cpp':
            case 'css':
            case 'dhtml':
            case 'diz':
            case 'h':
            case 'hpp':
            case 'htm':
            case 'html':
            case 'in':
            case 'inc':
            case 'js':
            case 'm4':
            case 'mak':
            case 'nfs':
            case 'nsi':
            case 'pas':
            case 'patch':
            case 'php':
            case 'php3':
            case 'php4':
            case 'php5':
            case 'phtml':
            case 'pl':
            case 'po':
            case 'py':
            case 'qmail':
            case 'sh':
            case 'shtml':
            case 'sql':
            case 'tcl':
            case 'tpl':
            case 'txt':
            case 'vbs':
            case 'xml':
            case 'xrc':
                return FTP_ASCII;
        }
        if ($file === '.htaccess') {
            return FTP_ASCII;
        }

        return FTP_BINARY;
    }

    /** @param array $arr
     * @param string $file
     *
     * @return boolean TRUE if $file found in $arr[]
     * @see ftpsync::$ignore
     *
     */
    private function isIgnore($arr, $file)
    {

        if (count($arr) === 0) {
            return false;
        }

        /**
         * -1 dirskip not found yet
         * 0+ placement
         */
        $dirskip = -1;

        foreach ($arr as $value) {

            // for files and dir under relative path
            if (!preg_match("/^\//", $value)) {
                //echo 'relative'."\n";
                if (mb_ereg_match(".*" . $value . ".*", $file)) {
                    return true;
                }
            } // will look into the path far as $value goes
            else {
                //echo "absolute\n";
                $exregex = explode("/", ltrim($value, '/'));        // ignore regex path
                $expath = explode("/", ltrim($file, '/'));        // real file path

                $findskip = true;
                $ii = 0; // `removed skip // skip '/httpdocs/' in $exregex[0]
                $iireal = 0; // look in $expath
                if ($dirskip !== -1) {
                    $findskip = false;
                    $iireal = $dirskip;
                }
                $lenExregex = count($exregex);
                while ($ii < $lenExregex) {
                    if ($findskip) {
                        //find first match
                        if (preg_match("/" . $exregex[$ii] . "/", $expath[$iireal])) {
                            //found
                            $findskip = false;
                            $dirskip = $iireal;
                        } else { // still looking for skip dir
                            $iireal++;
                        }
                    } else {
                        if (isset($expath[$iireal]) || array_key_exists($iireal, $expath)) {
                            if (preg_match("/" . $exregex[$ii] . "/", $expath[$iireal])) {
                                $ii++;
                                $iireal++;
                            } else {
                                return false;
                            }
                        } else {
                            //echo 'missing';
                            $ii = $lenExregex;
                        }
                    }
                } // end while

                return true;
            }
        }

        return false;
    }

    /** Returns in array form ftp_rawlist()
     *
     * @param $rmt_dir
     *
     * @return array [0]files under $rmt [] details per file
     * @return boolean FALSE if no $ftp_rawlist availible
     */
    function ftp_list_detailed($rmt_dir = '.')
    {
        $rmt_dir = rtrim($rmt_dir, '/');

        if (is_array($ls_details = @ftp_rawlist($this->conn_id, $rmt_dir))) {
            $items = [];

            foreach ($ls_details as $i => $ls_detail) {
                $chunks = preg_split("/\s+/", $ls_detail);
                list(
                    $item['rights'],
                    $item['number'],
                    $item['user'],
                    $item['group'],
                    $item['size'],
                    $item['month'],
                    $item['day'],
                    $item['time']
                    ) = $chunks;
                $item['type'] = $chunks[0]{0} === 'd' ? 'directory' : 'file';
                preg_match("/\S*$/", $ls_detail, $name);
                $item['name'] = $name[0];
                $items[$i] = $item;
            }

            return $items;
        } else {
            return false;
        }
    }

    //	private function ftp_check_conn($)

} // /ftpsync class






