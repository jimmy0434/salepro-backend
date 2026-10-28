<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Rdr}}`.
 */
class m230501_071420_create_Rdr_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Rdr}}', [
            'id' => $this->primaryKey(),
            'uid' => $this->string()->unique(),
            'salesman_id'=> $this->integer(),
            'bu'=> $this->string(),
            'email'=> $this->string(),
            'type'=> $this->string(),
            'subject'=> $this->string(),
            'description'=> $this->text(),
            'objectives'=> $this->string(),
            'impact'=> $this->string(),

            'blend_tt'=> $this->string(),
            'blend_cond'=> $this->string(),
            
            'output_tt'=> $this->string(),
            'output_cond'=> $this->string(),

            'final_blend_density_tt'=> $this->string(),
            'final_blend_density_cond'=> $this->string(),

            'density_before_adding_filler_tt'=> $this->string(),
            'density_before_adding_filler_cond'=> $this->string(),

            'total_ash_tt'=> $this->string(),
            'total_ash_cond'=> $this->string(),

            'melting_temp_tt'=> $this->string(),
            'melting_temp_cond'=> $this->string(),

            'melt_flow_tt'=> $this->string(),
            'melt_flow_cond'=> $this->string(),

            'gage_tt'=> $this->string(),
            'gage_cond'=> $this->string(),

            'creep_tt'=> $this->string(),
            'creep_cond'=> $this->string(),

            'Dart_drop_tt'=> $this->string(),
            'Dart_drop_cond'=> $this->string(),

            'tear_md_tt'=> $this->string(),
            'tear_md_cond'=> $this->string(),

            'tear_td_tt'=> $this->string(),
            'tear_td_cond'=> $this->string(),

            'tensile_md_yield_tt'=> $this->string(),
            'tensile_md_yield_cond'=> $this->string(),

            'tensile_md_break_tt'=> $this->string(),
            'tensile_md_break_cond'=> $this->string(),

            'tensile_td_yield_tt'=> $this->string(),
            'tensile_td_yield_cond'=> $this->string(),

            'tensile_td_break_tt'=> $this->string(),
            'tensile_td_break_cond'=> $this->string(),

            'elongation_md_break_tt'=> $this->string(),
            'elongation_md_break_cond'=> $this->string(),

            'elongation_td_break_tt'=> $this->string(),
            'elongation_td_break_cond'=> $this->string(),

            'modulus_1_md_tt'=> $this->string(),
            'modulus_1_md_cond'=> $this->string(),

            'modulus_1_td_tt'=> $this->string(),
            'modulus_1_td_cond'=> $this->string(),

            'modulus_2_md_tt'=> $this->string(),
            'modulus_2_md_cond'=> $this->string(),

            'modulus_2_td_tt'=> $this->string(),
            'modulus_2_td_cond'=> $this->string(),

            'static_cof_t_tt'=> $this->string(),
            'static_cof_t_cond'=> $this->string(),

            'kinetic_cof_t_tt'=> $this->string(),
            'kinetic_cof_t_cond'=> $this->string(),

            'static_cof_nt_tt'=> $this->string(),
            'static_cof_nt_cond'=> $this->string(),

            'kinetic_cof_nt_tt'=> $this->string(),
            'kinetic_cof_nt_cond'=> $this->string(),

            'haze_tt'=> $this->string(),
            'haze_cond'=> $this->string(),

            'shrink_md_tt'=> $this->string(),
            'shrink_md_cond'=> $this->string(),

            'shrink_td_tt'=> $this->string(),
            'shrink_td_cond'=> $this->string(),

            'stretch_md_tt'=> $this->string(),
            'stretch_md_cond'=> $this->string(),

            'stretch_td_tt'=> $this->string(),
            'stretch_td_cond'=> $this->string(),

            'surface_resistivity_tt'=> $this->string(),
            'surface_resistivity_cond'=> $this->string(),

            'otr_tt'=> $this->string(),
            'otr_cond'=> $this->string(),

            'wvtr_tt'=> $this->string(),
            'wvtr_cond'=> $this->string(),

            'other_1_tt'=> $this->string(),
            'other_1_cond'=> $this->string(),

            'other_2_tt'=> $this->string(),
            'other_2_cond'=> $this->string(),

            'other_3_tt'=> $this->string(),
            'other_3_cond'=> $this->string(),




            'approved'=> "ENUM('yes', 'no') DEFAULT ('no')",





            'created_at'=>
            $this->integer()->defaultValue(null),
            'updated_at'=>
            $this->integer()->defaultValue(null)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%Rdr}}');
    }
}
