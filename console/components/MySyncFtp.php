<?php
namespace console\components;

use GlSyncFtp\GlSyncFtp;
use GlSyncFtp\GlSyncFtpException;
use phpseclib\Net\SFTP;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class MySyncFtp extends GlSyncFtp
{
    /**
     * @var SFTP
     */
    private $sftp;

    /**
     * @var string
     */
    private $server;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;


    /**
     * @param string $root
     * @param array  $listfiles
     * @param array  $listdirs
     *
     * @throws GlSyncFtpException
     */
    public function getAllFiles($root, &$listfiles, &$listdirs)
    {
        $this->login();
        $this->getFiles($root, "", $listfiles, $listdirs);
    }

    /**
     * @throws GlSyncFtpException
     */
    private function login()
    {
        if (isset($this->sftp)) {
            return;
        }

        $this->sftp = new SFTP($this->server, $this->port);
        if (!$this->sftp->login($this->user, $this->password)) {
            throw new GlSyncFtpException('Login Failed');
        }
    }

    /**
     * @param string $root
     * @param string $relative
     * @param array  $listfiles
     * @param array  $listdirs
     */
    private function getFiles($root, $relative, &$listfiles, &$listdirs)
    {
        $files = $this->sftp->rawlist($root . '/' . $relative);
        if ($files === false) {
            return;
        }
        foreach ($files as $name => $raw) {
            if (($name != '.') && ($name != '..')) {
                if ($raw['type'] == NET_SFTP_TYPE_DIRECTORY) {
                    $listdirs[$relative . '/' . $name] = $raw;
                    $this->getFiles($root, $relative . '/' . $name, $listfiles, $listdirs);
                } else {
                    $listfiles[$relative . '/' . $name] = $raw;
                }
            }
        }
    }


    /**
     * @param array         $list
     * @param callable|null $syncdir
     * @param callable|null $syncop
     *
     * @throws GlSyncFtpException
     */
    public function syncDirectories($list, callable $syncdir = null, callable $syncop = null)
    {
        foreach ($list as $src => $dst) {
            if ($syncdir) {
                $syncdir($src, $dst);
            }
            $this->syncDirectory(
                $src,
                $dst,
                $syncop
            );
        }
    }

    /**
     * delete files unknowns on ftp server
     *
     * @param string $src
     * @param string $dst
     * @param callable|null $syncop
     */
    private function syncDelete($src, $dst,callable $syncop = null) {
        $files = [];
        $dirs  = [];
        $this->getFiles($dst, "", $files, $dirs);

        // delete on ftp server, files not present in local directory
        foreach ($files as $name => $raw) {
            if (!file_exists($src . $name)) {
                $filepathFtp = $dst . strtr($name, ["\\" => "/"]);
                if ($syncop) {
                    $syncop(self::DELETE_FILE, $filepathFtp);
                }
                $this->sftp->delete($filepathFtp);
            }
        }

        // delete on ftp server, unknowns directories
        $dirs = array_reverse($dirs);
        foreach ($dirs as $name => $raw) {
            if (!file_exists($src . $name)) {
                $filepathFtp = $dst . strtr($name, ["\\" => "/"]);
                if ($syncop) {
                    $syncop(self::DELETE_DIR, $filepathFtp);
                }
                $this->sftp->rmdir($filepathFtp);
            }
        }
    }


    /**
     * sync local directory with ftp directory
     *
     * @param string        $src
     * @param string        $dst
     * @param callable|null $syncop
     *
     * @throws GlSyncFtpException
     */
    public function syncDirectory($src, $dst, callable $syncop = null)
    {
        $this->login();

       // $this->syncDelete($src, $dst, $syncop);

        // create new directories
        $finderdir = new Finder();
        $finderdir->directories()->ignoreDotFiles(false)->followLinks()->in($src)->notName('.git*');

        /**
         * @var SplFileInfo $dir
         */
        foreach ($finderdir as $dir) {
            $dirpathFtp = $dst . "/" . strtr($dir->getRelativePathname(), ["\\" => "/"]);
            $stat       = $this->sftp->stat($dirpathFtp);
            if (!$stat) {
                if ($syncop) {
                    $syncop(self::CREATE_DIR, $dirpathFtp);
                }
                $this->sftp->mkdir($dirpathFtp, $dir->getRealPath(), SFTP::SOURCE_LOCAL_FILE);
                $this->sftp->chmod(0755, $dirpathFtp, $dir->getRealPath());
            }
        }

        // copy new files or update if younger
        $finderdir = new Finder();
        $finderdir->files()->ignoreDotFiles(false)->followLinks()->in($src)->notName('.git*');

        /**
         * @var SplFileInfo $file
         */
        foreach ($finderdir as $file) {
            $filepathFtp = $dst . "/" . strtr($file->getRelativePathname(), ["\\" => "/"]);
            $stat        = $this->sftp->stat($filepathFtp);
            if (!$stat) {
                if ($syncop) {
                    $syncop(self::NEW_FILE, $filepathFtp);
                }
                $this->sftp->put($filepathFtp, $file->getRealPath(), SFTP::SOURCE_LOCAL_FILE);
            } else {
                $size = $this->sftp->size($filepathFtp);
                if (($file->getMTime() > $stat['mtime']) || ($file->getSize() != $size)) {
                    if ($syncop) {
                        $syncop(self::UPDATE_FILE, $filepathFtp);
                    }
                    $this->sftp->put($filepathFtp, $file->getRealPath(), SFTP::SOURCE_LOCAL_FILE);
                }
            }
        }
    }}