<?php
namespace common\components\helpers;

use common\models\LkSettings;
use common\models\UserContact;
use common\models\UserContractorPayment;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class UserHelper
{
    const PROFILE_ACTION_INFO = 'profile-info';
    const PROFILE_ACTION_CONTACT = 'user-contact';

    /**
     * @param UserContact $contact
     *
     * @return string
     */
    public static function getFIO(UserContact $contact): string
    {
        $fio = '';

        if (!empty($contact->lastname)) {
            $fio .= $contact->lastname.' ';
        }
        if (!empty($contact->firstname)) {
            $fio .= $contact->firstname.' ';
        }
        if (!empty($contact->secondname)) {
            $fio .= $contact->secondname;
        }

        return trim($fio);
    }

    /**
     * @param string $sex
     *
     * @return string
     */
    public static function getSexTitle(string $sex) : string
    {
        if ($sex === UserContact::SEX_MALE) {
            return 'Господин';
        } elseif ($sex === UserContact::SEX_FEMALE) {
            return 'Госпожа';
        }

        return 'Не указан';
    }

    /**
     * @param string $phone
     *
     * @return string
     */
    public static function getContactPhoneHtml($phone = '') : string
    {
        $html = Html::beginTag('div', ['class' => 'user-contact-phones-container-item',]).PHP_EOL;
        $html .= Html::input('phone', 'UserContact[phones][]', $phone, ['class' => 'form-control user-contact-phones-input',]).PHP_EOL;
        $html .= Html::beginTag('div', ['class' => 'tb-col-action user-contact-phones-actions',]).PHP_EOL;
        $html .= Html::a('<em class="icon ni ni-trash"></em>', '#', ['class' => 'link-cross mr-sm-n1 user-contact-phones-delete',]).PHP_EOL;
        $html .= Html::endTag('div').PHP_EOL;
        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * @param int $level
     *
     * @return string
     */
    public static function getLoader() : string
    {
        return Html::tag('div', Html::img('/images/loader.gif', ['style' => 'display: none; width: 15px; vertical-align: middle;',]), ['class' => 'cart-loader', 'style' => 'display: inline-block;',]);
    }

    /**
     * @return string
     */
    public static function getLoaderIcon() : string
    {
        return Html::tag('div',
            Html::tag('div',
                Html::tag('span', 'Загрузка...', ['class' => 'sr-only',]),
                ['class' => 'spinner-border text-primary', 'role' => 'status', 'style' => 'display: none; width: 1.3rem; height: 1.3rem;',]
            ),
            ['class' => 'icon-loader', 'style' => 'display: inline-block; vertical-align: middle; margin-right: 5px;',]
        );
    }

    /**
     * @param UserContractorPayment $payment
     * @param int                   $entityID
     * @param bool                  $isAjax
     *
     * @return string
     */
    public static function getUserContractorEntityPaymentRowHtml(UserContractorPayment $payment, int $entityID, bool $isAjax = false) : string
    {
        $html = '
            <tr data-id="'.$payment->id.'">
                <td class="tb-col-os">'.$payment->getTypeTitle($payment->type).'</td>
                <td class="tb-col-ip"><span class="sub-text">'.$payment->getInfo().'</span></td>
                <td class="tb-col-ip"><span class="sub-text">'.($payment->is_default ? '<span class="badge badge-dim badge-pill badge-outline-primary">Да</span>' : 'Нет' ).'</span></td>
                <td class="tb-col-action">';
                if (!$isAjax) {
                    if (!$payment->is_default) {
                        $html .= UserHelper::getLoaderIcon();
                        $html .= '<a href="#" class="link-cross mr-sm-n1 contractor-entity-payment-delete" data-id="' . $payment->id . '" data-entity_id="' . $entityID . '"><em class="icon ni ni-trash"></em></a>';
                    }
                    $html .= ' <a href="#" class="link-cross mr-sm-n1" data-toggle="modal" data-target="#contractor-entity-' . $entityID . '-payment-edit-' . $payment->id . '"><em class="icon ni ni-edit"></em></a>';
                }
        $html .= '</td>
            </tr>';

        return $html;
    }

    /**
     * @param UserContractorPayment $payment
     * @param int                   $personID
     * @param bool                  $isAjax
     *
     * @return string
     */
    public static function getUserContractorPersonPaymentRowHtml(UserContractorPayment $payment, int $personID, bool $isAjax = false) : string
    {
        $html = '
            <tr data-id="'.$payment->id.'">
                <td class="tb-col-os">'.$payment->getTypeTitle($payment->type).'</td>
                <td class="tb-col-ip"><span class="sub-text">'.$payment->getInfo().'</span></td>
                <td class="tb-col-ip"><span class="sub-text">'.($payment->is_default ? '<span class="badge badge-dim badge-pill badge-outline-primary">Да</span>' : 'Нет' ).'</span></td>
                <td class="tb-col-action">';
                if (!$isAjax) {
                    if (!$payment->is_default) {
                        $html .= UserHelper::getLoaderIcon();
                        $html .= '<a href="#" class="link-cross mr-sm-n1 contractor-person-payment-delete" data-id="' . $payment->id . '" data-person_id="' . $personID . '"><em class="icon ni ni-trash"></em></a>';
                    }
                    $html .= ' <a href="#" class="link-cross mr-sm-n1" data-toggle="modal" data-target="#contractor-person-' . $personID . '-payment-edit-' . $payment->id . '"><em class="icon ni ni-edit"></em></a>';
                }
        $html .= '</td>
            </tr>';

        return $html;
    }

    /**
     * @return LkSettings
     */
    public static function getLkSettings() : LkSettings
    {
        $model = LkSettings::find()->where(['>', 'id', 0])->one();

        if (!$model) {
            $model = new LkSettings();
        }

        return $model;
    }
}