<?php
namespace common\components\helpers;

use backend\components\helpers\IconHelper;
use common\models\FullPrice;
use common\models\ReferenceDelivery;
use common\models\ReferenceDeliveryGroup;
use common\models\ReferencePayment;
use common\models\ReferencePaymentGroup;
use common\models\SettingsCheckoutBuyer;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\Html;


class ReferenceHelper
{
    const BUYER_DELIVERY_GROUP = 'DeliveryGroup';
    const BUYER_DELIVERY = 'Delivery';
    const BUYER_PAYMENT_GROUP = 'PaymentGroup';

    /**
     * @return array
     */
    public static function getFullPricePartners() : array
    {
        $partners = [];
        $rows = FullPrice::find()->select('partner')->distinct(true)->asArray()->orderBy(['partner' => SORT_ASC,])->column();

        foreach ($rows as $row) {
            $partners[$row] = $row;
        }

        return $partners;
    }

    /**
     * @param             $id
     * @param ActiveQuery $query
     * @param array       $data
     *
     * @return string
     */
    public static function getMultipleSelect($id, ActiveQuery $query, array $data = []) : string
    {
        $html = Html::beginTag('select', ['multiple' => 'multiple', 'class' => 'multi-select', 'id' => $id, 'name' => $id.'[]',]);
        $rows = $query->select(['id', 'name',])->where(['is_active' => true,])->orderBy(['name' => SORT_ASC,])->asArray()->all();

        foreach ($rows as $row) {
            $options = ['value' => $row['id'],];
            if (in_array($row['id'], $data)) {
                $options['selected'] = true;
            }
            $html .= Html::tag('option', $row['name'], $options);
        }

        $html .= Html::endTag('select');

        return $html;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     *
     * @return ArrayDataProvider
     */
    public static function getDeliveryGroupProvider(SettingsCheckoutBuyer $model) : ArrayDataProvider
    {
        $provider = new ArrayDataProvider();
        $data = $model->getData();
        if (!empty($data[self::BUYER_DELIVERY_GROUP])) {
            $allModels = [];
            foreach ($data[self::BUYER_DELIVERY_GROUP] as $id => $item) {
                $id = (int) $id;
                $name = ReferenceDeliveryGroup::find()->select('name')->where(['id' => $id,])->asArray()->scalar();
                $allModels[] = ['id' => $id, 'name' => $name, 'deliveryCount' => !empty($item[self::BUYER_DELIVERY]) ? count($item[self::BUYER_DELIVERY]) : 0,];
            }

            $provider->setModels($allModels);
            $provider->setSort(['attributes' => ['name'],]);
            $provider->setPagination(false);
        }

        return $provider;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     *
     * @return ArrayDataProvider
     */
    public static function getDeliveryProvider(SettingsCheckoutBuyer $model, int $deliveryGroupID) : ArrayDataProvider
    {
        $provider = new ArrayDataProvider();
        $data = $model->getData();
        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY])) {

            $allModels = [];
            foreach ($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY] as $id => $item) {
                $id = (int) $id;
                $name = ReferenceDelivery::find()->select('name')->where(['id' => $id,])->asArray()->scalar();
                $allModels[] = ['id' => $id, 'name' => $name, 'paymentGroupCount' => !empty($item[self::BUYER_PAYMENT_GROUP]) ? count($item[self::BUYER_PAYMENT_GROUP]) : 0,];
            }

            $provider->setModels($allModels);
            $provider->setSort(['attributes' => ['name'],]);
            $provider->setPagination(false);
        }

        return $provider;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     *
     * @return ArrayDataProvider
     */
    public static function getPaymentGroupProvider(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID) : ArrayDataProvider
    {
        $provider = new ArrayDataProvider();
        $data = $model->getData();
        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP])) {

            $allModels = [];
            foreach ($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP] as $id => $ids) {
                $id = (int) $id;
                $name = ReferencePaymentGroup::find()->select('name')->where(['id' => $id,])->asArray()->scalar();
                $allModels[] = ['id' => $id, 'name' => $name, 'paymentCount' => count($ids),];
            }

            $provider->setModels($allModels);
            $provider->setSort(['attributes' => ['name'],]);
            $provider->setPagination(false);
        }

        return $provider;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     * @param int                   $paymentGroupID
     *
     * @return ArrayDataProvider
     */
    public static function getPaymentProvider(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID, int $paymentGroupID) : ArrayDataProvider
    {
        $provider = new ArrayDataProvider();
        $data = $model->getData();
        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID])) {

            $allModels = [];
            foreach ($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID] as $id) {
                $id = (int) $id;
                $name = ReferencePayment::find()->select('name')->where(['id' => $id,])->asArray()->scalar();
                $allModels[] = ['id' => $id, 'name' => $name,];
            }

            $provider->setModels($allModels);
            $provider->setSort(['attributes' => ['name'],]);
            $provider->setPagination(false);
        }

        return $provider;
    }

    /** ADDERS */

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     *
     * @return SettingsCheckoutBuyer
     */
    public static function addDeliveryGroup(SettingsCheckoutBuyer $model, int $deliveryGroupID) : SettingsCheckoutBuyer
    {
        $data = $model->getData();
        if (empty($data[self::BUYER_DELIVERY_GROUP])) {
            $data[self::BUYER_DELIVERY_GROUP] = [];
        }

        if (empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID] = [self::BUYER_DELIVERY => [],];
        }

        $model->setData($data);

        return $model;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     *
     * @return SettingsCheckoutBuyer
     */
    public static function addDelivery(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID) : SettingsCheckoutBuyer
    {
        $data = $model->getData();
        if (empty($data[self::BUYER_DELIVERY_GROUP])) {
            $data[self::BUYER_DELIVERY_GROUP] = [];
        }

        if (empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID] = [self::BUYER_DELIVERY => [],];
        }

        if (empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID] = [self::BUYER_PAYMENT_GROUP => [],];
        }

        $model->setData($data);

        return $model;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     * @param int                   $paymentGroupID
     *
     * @return SettingsCheckoutBuyer
     */
    public static function addPaymentGroup(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID, int $paymentGroupID) : SettingsCheckoutBuyer
    {
        $data = $model->getData();
        if (empty($data[self::BUYER_DELIVERY_GROUP])) {
            $data[self::BUYER_DELIVERY_GROUP] = [];
        }

        if (empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID] = [self::BUYER_DELIVERY => [],];
        }

        if (empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID] = [self::BUYER_PAYMENT_GROUP => [],];
        }

        if (empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID] = [];
        }

        $model->setData($data);

        return $model;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     * @param int                   $paymentGroupID
     * @param int                   $paymentID
     *
     * @return SettingsCheckoutBuyer
     */
    public static function addPayment(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID, int $paymentGroupID, int $paymentID) : SettingsCheckoutBuyer
    {
        $data = $model->getData();

        if (empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID] = [];
        }

        if (!in_array($paymentID, $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID][] = $paymentID;
        }

        $model->setData($data);

        return $model;
    }


    /** SETTERS */


    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $oldDeliveryGroupID
     * @param int                   $newDeliveryGroupID
     *
     * @return SettingsCheckoutBuyer
     */
    public static function setDeliveryGroup(SettingsCheckoutBuyer $model, int $oldDeliveryGroupID, int $newDeliveryGroupID) : SettingsCheckoutBuyer
    {
        $data = $model->getData();
        if (empty($data[self::BUYER_DELIVERY_GROUP])) {
            $data[self::BUYER_DELIVERY_GROUP] = [];
        }

        if (!empty($data[self::BUYER_DELIVERY_GROUP][$oldDeliveryGroupID])) {
            $data[self::BUYER_DELIVERY_GROUP][$newDeliveryGroupID] = $data[self::BUYER_DELIVERY_GROUP][$oldDeliveryGroupID];
            unset($data[self::BUYER_DELIVERY_GROUP][$oldDeliveryGroupID]);
        } else {
            $data[self::BUYER_DELIVERY_GROUP][$newDeliveryGroupID] = [self::BUYER_DELIVERY => [],];
        }

        $model->setData($data);

        return $model;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $oldDeliveryID
     * @param int                   $newDeliveryID
     *
     * @return SettingsCheckoutBuyer
     */
    public static function setDelivery(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $oldDeliveryID, int $newDeliveryID) : SettingsCheckoutBuyer
    {
        $data = $model->getData();
        if (empty($data[self::BUYER_DELIVERY_GROUP])) {
            $data[self::BUYER_DELIVERY_GROUP] = [];
        }

        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$oldDeliveryID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$newDeliveryID] = $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$oldDeliveryID];
            unset($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$oldDeliveryID]);
        } else {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$newDeliveryID] = [self::BUYER_PAYMENT_GROUP => [],];
        }

        $model->setData($data);

        return $model;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     * @param int                   $oldPaymentGroupID
     * @param int                   $newPaymentGroupID
     *
     * @return SettingsCheckoutBuyer
     */
    public static function setPaymentGroup(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID, int $oldPaymentGroupID, int $newPaymentGroupID) : SettingsCheckoutBuyer
    {
        $data = $model->getData();
        if (empty($data[self::BUYER_DELIVERY_GROUP])) {
            $data[self::BUYER_DELIVERY_GROUP] = [];
        }

        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$oldPaymentGroupID])) {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$newPaymentGroupID] = $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$oldPaymentGroupID];
            unset($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$oldPaymentGroupID]);
        } else {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$newPaymentGroupID] = [];
        }

        $model->setData($data);

        return $model;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     * @param int                   $paymentGroupID
     * @param int                   $oldPaymentID
     * @param int                   $newPaymentID
     *
     * @return SettingsCheckoutBuyer
     */
    public static function setPayment(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID, int $paymentGroupID, int $oldPaymentID, int $newPaymentID) : SettingsCheckoutBuyer
    {
        if ($oldPaymentID == $newPaymentID) {
            return $model;
        }

        $data = $model->getData();
        if (empty($data[self::BUYER_DELIVERY_GROUP])) {
            $data[self::BUYER_DELIVERY_GROUP] = [];
        }

        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID])) {
            if (in_array($oldPaymentID, $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID])) {
                $list = $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID];
                foreach ($list as $index => $id) {
                    if ($id == $oldPaymentID) {
                        $list[$index] = $newPaymentID;
                        break;
                    }
                }

                $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID] = array_values(array_unique($list));
            } else {
                $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID][] = $newPaymentID;
            }
        } else {
            $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID] = [$newPaymentID,];
        }

        $model->setData($data);

        return $model;
    }

    /** DELETERS */

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     *
     * @return bool
     */
    public static function deleteDeliveryGroup(SettingsCheckoutBuyer $model, int $deliveryGroupID) : bool
    {
        $data = $model->getData();

        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID])) {
            unset($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID]);
            $model->setData($data);

            return $model->save(false);
        }

        return false;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     *
     * @return bool
     */
    public static function deleteDelivery(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID) : bool
    {
        $data = $model->getData();

        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID])) {
            unset($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID]);
            $model->setData($data);

            return $model->save(false);
        }

        return false;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     * @param int                   $paymentGroupID
     *
     * @return bool
     */
    public static function deletePaymentGroup(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID, int $paymentGroupID) : bool
    {
        $data = $model->getData();

        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID])) {
            unset($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID]);
            $model->setData($data);

            return $model->save(false);
        }

        return false;
    }

    /**
     * @param SettingsCheckoutBuyer $model
     * @param int                   $deliveryGroupID
     * @param int                   $deliveryID
     * @param int                   $paymentGroupID
     * @param int                   $paymentID
     *
     * @return bool
     */
    public static function deletePayment(SettingsCheckoutBuyer $model, int $deliveryGroupID, int $deliveryID, int $paymentGroupID, int $paymentID) : bool
    {
        $data = $model->getData();

        $isDeleted = false;
        if (!empty($data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID])) {
            $list = $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID];

            foreach ($list as $index => $id) {
                if ($id == $paymentID) {
                    unset($list[$index]);
                    $isDeleted = true;
                    break;
                }
            }

            if ($isDeleted) {
                $data[self::BUYER_DELIVERY_GROUP][$deliveryGroupID][self::BUYER_DELIVERY][$deliveryID][self::BUYER_PAYMENT_GROUP][$paymentGroupID] = array_values($list);

                $model->setData($data);

                return $model->save(false);
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public static function getClassIcon() : string
    {
        $icon = IconHelper::ICON_REFERENCE;

        return $icon;
    }
}