<?php


namespace App\Http\Services\TransportServices;


interface TransportSource
{
    public function GetCityLists();
    public function PreRequest();
    public function PrepareHeaders();
    public function PrepareBody();
}
