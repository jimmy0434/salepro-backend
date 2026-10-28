<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use cnd\admin\models\activerecords\Log;

use Yii;

/**
 * This is the model class for table "mpk_rdr".
 *
 * @property int $id
 * @property string $uid
 * @property int $salesman_id
 * @property string $bu
 * @property string $email
 * @property string $type
 * @property string $subject
 * @property string $description
 * @property string $objectives
 * @property string $impact
 * @property string $blend_tt
 * @property string $blend_cond
 * @property string $output_tt
 * @property string $output_cond
 * @property string $final_blend_density_tt
 * @property string $final_blend_density_cond
 * @property string $density_before_adding_filler_tt
 * @property string $density_before_adding_filler_cond
 * @property string $total_ash_tt
 * @property string $total_ash_cond
 * @property string $melting_temp_tt
 * @property string $melting_temp_cond
 * @property string $melt_flow_tt
 * @property string $melt_flow_cond
 * @property string $gage_tt
 * @property string $gage_cond
 * @property string $creep_tt
 * @property string $creep_cond
 * @property string $Dart_drop_tt
 * @property string $Dart_drop_cond
 * @property string $tear_md_tt
 * @property string $tear_md_cond
 * @property string $tear_td_tt
 * @property string $tear_td_cond
 * @property string $tensile_md_yield_tt
 * @property string $tensile_md_yield_cond
 * @property string $tensile_md_break_tt
 * @property string $tensile_md_break_cond
 * @property string $tensile_td_yield_tt
 * @property string $tensile_td_yield_cond
 * @property string $tensile_td_break_tt
 * @property string $tensile_td_break_cond
 * @property string $elongation_md_break_tt
 * @property string $elongation_md_break_cond
 * @property string $elongation_td_break_tt
 * @property string $elongation_td_break_cond
 * @property string $modulus_1_md_tt
 * @property string $modulus_1_md_cond
 * @property string $modulus_1_td_tt
 * @property string $modulus_1_td_cond
 * @property string $modulus_2_md_tt
 * @property string $modulus_2_md_cond
 * @property string $modulus_2_td_tt
 * @property string $modulus_2_td_cond
 * @property string $static_cof_t_tt
 * @property string $static_cof_t_cond
 * @property string $kinetic_cof_t_tt
 * @property string $kinetic_cof_t_cond
 * @property string $static_cof_nt_tt
 * @property string $static_cof_nt_cond
 * @property string $kinetic_cof_nt_tt
 * @property string $kinetic_cof_nt_cond
 * @property string $haze_tt
 * @property string $haze_cond
 * @property string $shrink_md_tt
 * @property string $shrink_md_cond
 * @property string $shrink_td_tt
 * @property string $shrink_td_cond
 * @property string $stretch_md_tt
 * @property string $stretch_md_cond
 * @property string $stretch_td_tt
 * @property string $stretch_td_cond
 * @property string $surface_resistivity_tt
 * @property string $surface_resistivity_cond
 * @property string $otr_tt
 * @property string $otr_cond
 * @property string $wvtr_tt
 * @property string $wvtr_cond
 * @property string $other_1_tt
 * @property string $other_1_cond
 * @property string $other_2_tt
 * @property string $other_2_cond
 * @property string $other_3_tt
 * @property string $other_3_cond
 * @property string $approved
 * @property int $created_at
 * @property int $updated_at
 */
class Rdr extends \common\components\ActiveRecord
{
    const NO = 'no';
    const YES = 'yes';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpk_rdr';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salesman_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'approved'], 'string'],
            [['uid', 'bu', 'email', 'type', 'subject', 'objectives', 'impact', 'blend_tt', 'blend_cond', 'output_tt', 'output_cond', 'final_blend_density_tt', 'final_blend_density_cond', 'density_before_adding_filler_tt', 'density_before_adding_filler_cond', 'total_ash_tt', 'total_ash_cond', 'melting_temp_tt', 'melting_temp_cond', 'melt_flow_tt', 'melt_flow_cond', 'gage_tt', 'gage_cond', 'creep_tt', 'creep_cond', 'Dart_drop_tt', 'Dart_drop_cond', 'tear_md_tt', 'tear_md_cond', 'tear_td_tt', 'tear_td_cond', 'tensile_md_yield_tt', 'tensile_md_yield_cond', 'tensile_md_break_tt', 'tensile_md_break_cond', 'tensile_td_yield_tt', 'tensile_td_yield_cond', 'tensile_td_break_tt', 'tensile_td_break_cond', 'elongation_md_break_tt', 'elongation_md_break_cond', 'elongation_td_break_tt', 'elongation_td_break_cond', 'modulus_1_md_tt', 'modulus_1_md_cond', 'modulus_1_td_tt', 'modulus_1_td_cond', 'modulus_2_md_tt', 'modulus_2_md_cond', 'modulus_2_td_tt', 'modulus_2_td_cond', 'static_cof_t_tt', 'static_cof_t_cond', 'kinetic_cof_t_tt', 'kinetic_cof_t_cond', 'static_cof_nt_tt', 'static_cof_nt_cond', 'kinetic_cof_nt_tt', 'kinetic_cof_nt_cond', 'haze_tt', 'haze_cond', 'shrink_md_tt', 'shrink_md_cond', 'shrink_td_tt', 'shrink_td_cond', 'stretch_md_tt', 'stretch_md_cond', 'stretch_td_tt', 'stretch_td_cond', 'surface_resistivity_tt', 'surface_resistivity_cond', 'otr_tt', 'otr_cond', 'wvtr_tt', 'wvtr_cond', 'other_1_tt', 'other_1_cond', 'other_2_tt', 'other_2_cond', 'other_3_tt', 'other_3_cond'], 'string', 'max' => 255],
            [['uid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'salesman_id' => 'Salesman ID',
            'bu' => 'Bu',
            'email' => 'Email',
            'type' => 'Type',
            'subject' => 'Subject',
            'description' => 'Description',
            'objectives' => 'Objectives',
            'impact' => 'Impact',
            'blend_tt' => 'Blend Tt',
            'blend_cond' => 'Blend Cond',
            'output_tt' => 'Output Tt',
            'output_cond' => 'Output Cond',
            'final_blend_density_tt' => 'Final Blend Density Tt',
            'final_blend_density_cond' => 'Final Blend Density Cond',
            'density_before_adding_filler_tt' => 'Density Before Adding Filler Tt',
            'density_before_adding_filler_cond' => 'Density Before Adding Filler Cond',
            'total_ash_tt' => 'Total Ash Tt',
            'total_ash_cond' => 'Total Ash Cond',
            'melting_temp_tt' => 'Melting Temp Tt',
            'melting_temp_cond' => 'Melting Temp Cond',
            'melt_flow_tt' => 'Melt Flow Tt',
            'melt_flow_cond' => 'Melt Flow Cond',
            'gage_tt' => 'Gage Tt',
            'gage_cond' => 'Gage Cond',
            'creep_tt' => 'Creep Tt',
            'creep_cond' => 'Creep Cond',
            'Dart_drop_tt' => 'Dart Drop Tt',
            'Dart_drop_cond' => 'Dart Drop Cond',
            'tear_md_tt' => 'Tear Md Tt',
            'tear_md_cond' => 'Tear Md Cond',
            'tear_td_tt' => 'Tear Td Tt',
            'tear_td_cond' => 'Tear Td Cond',
            'tensile_md_yield_tt' => 'Tensile Md Yield Tt',
            'tensile_md_yield_cond' => 'Tensile Md Yield Cond',
            'tensile_md_break_tt' => 'Tensile Md Break Tt',
            'tensile_md_break_cond' => 'Tensile Md Break Cond',
            'tensile_td_yield_tt' => 'Tensile Td Yield Tt',
            'tensile_td_yield_cond' => 'Tensile Td Yield Cond',
            'tensile_td_break_tt' => 'Tensile Td Break Tt',
            'tensile_td_break_cond' => 'Tensile Td Break Cond',
            'elongation_md_break_tt' => 'Elongation Md Break Tt',
            'elongation_md_break_cond' => 'Elongation Md Break Cond',
            'elongation_td_break_tt' => 'Elongation Td Break Tt',
            'elongation_td_break_cond' => 'Elongation Td Break Cond',
            'modulus_1_md_tt' => 'Modulus 1 Md Tt',
            'modulus_1_md_cond' => 'Modulus 1 Md Cond',
            'modulus_1_td_tt' => 'Modulus 1 Td Tt',
            'modulus_1_td_cond' => 'Modulus 1 Td Cond',
            'modulus_2_md_tt' => 'Modulus 2 Md Tt',
            'modulus_2_md_cond' => 'Modulus 2 Md Cond',
            'modulus_2_td_tt' => 'Modulus 2 Td Tt',
            'modulus_2_td_cond' => 'Modulus 2 Td Cond',
            'static_cof_t_tt' => 'Static Cof T Tt',
            'static_cof_t_cond' => 'Static Cof T Cond',
            'kinetic_cof_t_tt' => 'Kinetic Cof T Tt',
            'kinetic_cof_t_cond' => 'Kinetic Cof T Cond',
            'static_cof_nt_tt' => 'Static Cof Nt Tt',
            'static_cof_nt_cond' => 'Static Cof Nt Cond',
            'kinetic_cof_nt_tt' => 'Kinetic Cof Nt Tt',
            'kinetic_cof_nt_cond' => 'Kinetic Cof Nt Cond',
            'haze_tt' => 'Haze Tt',
            'haze_cond' => 'Haze Cond',
            'shrink_md_tt' => 'Shrink Md Tt',
            'shrink_md_cond' => 'Shrink Md Cond',
            'shrink_td_tt' => 'Shrink Td Tt',
            'shrink_td_cond' => 'Shrink Td Cond',
            'stretch_md_tt' => 'Stretch Md Tt',
            'stretch_md_cond' => 'Stretch Md Cond',
            'stretch_td_tt' => 'Stretch Td Tt',
            'stretch_td_cond' => 'Stretch Td Cond',
            'surface_resistivity_tt' => 'Surface Resistivity Tt',
            'surface_resistivity_cond' => 'Surface Resistivity Cond',
            'otr_tt' => 'Otr Tt',
            'otr_cond' => 'Otr Cond',
            'wvtr_tt' => 'Wvtr Tt',
            'wvtr_cond' => 'Wvtr Cond',
            'other_1_tt' => 'Other 1 Tt',
            'other_1_cond' => 'Other 1 Cond',
            'other_2_tt' => 'Other 2 Tt',
            'other_2_cond' => 'Other 2 Cond',
            'other_3_tt' => 'Other 3 Tt',
            'other_3_cond' => 'Other 3 Cond',
            'approved' => 'Approved',
            'reff' => 'Reff',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesman()
    {
        return $this->hasOne(Salesman::className(), ['id' => 'salesman_id']);
    }

    /**
     * {@inheritdoc}
     * @return RdrQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RdrQuery(get_called_class());
    }
    public function beforeSave($insert)
    {
        if ($this->isNewRecord || !$this->uid) {
            $this->uid = uniqid('rdr-', true);
        }
           // comment this before run migration for search index update
           if (!Yii::$app->user->isGuest && !$this->salesman_id && Yii::$app->user->identity->type == User::TYPE_SALESMAN) {
            $this->salesman_id = Yii::$app->user->identity->id;
            $this->email = Yii::$app->user->identity->email;
        }

        return parent::beforeSave($insert);
    }
   
    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->approved = static::NO;
        }
        return parent::beforeValidate();
    }

     public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $list = parent::toArray($fields, $expand, $recursive);


        return $list;
    }
}
