<?php


namespace App\Builders;


use Illuminate\Database\Eloquent\Model;

interface Builder
{
    public  function InitiateExisting (Model $object);

    public function BuildMonthlyIn ();

    public function BuildDailyIn ();

    public function BuildMonthlyOut ();

    public function BuildDailyOut ();

    public function BuildMonthlySpoil ();

    public function BuildDailySpoil ();

    public function BuildProductWithMaterialNorms ();

    public function BuildProductWithUsedMaterials();


    public function BuildStock ();

}