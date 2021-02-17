@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Текущие данные по материалам') }}</div>

                    <div class="card-body">
                        <div>Мешок мука 50 кг</div>
                        <div>Мешок ПСК 20 кг бумага</div>
                        <div>Мешок ПСКБ 50 кг</div>
                        <div>Мешок ССХ 50 кг</div>
                        <div>Мешок ШКС 50 кг</div>
                        <div>Мешок Торкрет 50 кг</div>
                        <div>МКР</div>
                        <div>Пленка</div>
                        <div>Натрий</div>
                        <div>Песок</div>
                        <div>Цемент с/с</div>
                        <div>Пластификатор</div>
                        <div>Крошка</div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Ввод информации') }}</div>

                    <div class="card-body">
                        <div>Ввод моточасов</div>
                        <div>Ввод произведенной продукции</div>
                    </div>
                </div>
                <div id="app">
                    <example-component></example-component>
                </div>
            </div>
        </div>
    </div>
@endsection
