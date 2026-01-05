@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')


@endsection

@section('content')

    @include('layouts._breadcrumbs')

    <div class="converters container-xs">
        <section class="converters__converter">
            <div class="converters__section-title">
                <h2>Перевод величин емкостей</h2>
            </div>
            <div class="converters__card">
                <div class="converters__controls">
                    <div class="form-input">
                        <label for="capacity-original-value">Введите исходное значние</label>
                        <div class="converters__input-line">
                            <input type="text" id="capacity-original-value" placeholder='0'>
                            <div class="form-select">
                                <label for="capacity-original-unit" class="sr-only">Единицы измерения</label>
                                <select name="platform" id="capacity-original-unit" class="js-select">
                                    <option value="n">нанофарад(нФ)</option>
                                    <option value="m">микрофарад(мкФ)</option>
                                    <option value="p">пикофарад(пФ)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="converters__result">
                    <span class="converters__result-title">Преобразованные значения</span>
                    <div class="converters__result-item">
                        <span id="convertert-capacity-m">0</span>
                        <span>микрофарад(мкФ)</span>
                    </div>
                    <div class="converters__result-item">
                        <span id="convertert-capacity-p">0</span>
                        <span>пикофарад(пФ)</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="converters__converter">
            <div class="converters__section-title">
                <h2>Перевод величин индуктивностей</h2>
            </div>
            <div class="converters__card">
                <div class="converters__controls">
                    <div class="form-input">
                        <label for="inductance-original-value">Введите исходное значние</label>
                        <div class="converters__input-line">
                            <input type="text" id="inductance-original-value" placeholder='0'>
                            <div class="form-select">
                                <label for="inductance-original-unit" class="sr-only">Единицы измерения</label>
                                <select name="platform" id="inductance-original-unit" class="js-select">
                                    <option value="m">микрогенри(мкГн)</option>
                                    <option value="mm">миллигенри(мГн)</option>
                                    <option value="n">наногенри(нГн)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="converters__result">
                    <span class="converters__result-title">Преобразованные значения</span>
                    <div class="converters__result-item">
                        <span id="convert-inductance-mm">0</span>
                        <span>миллигенри(мГн)</span>
                    </div>
                    <div class="converters__result-item">
                        <span id="convert-inductance-n">0</span>
                        <span>наногенри(нГн)</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('js')

    <!-- jQuery -->
    {!! Html::script('/plugins/jquery/jquery.min.js') !!}

    <script>

        $(document).ready(function() {
            let convert = function() {
                let inVal = $('#capacity-original-value').val();
                let unitVal = $('#capacity-original-unit').val();
                let num = 0;

                if (unitVal === 'n') {
                    num = Number(inVal) * 1000000000;
                } else if(unitVal === 'm') {
                    num = Number(inVal) * 1000000;
                } else if (unitVal === 'p') {
                    num = Number(inVal) * 100000000000;
                }

                $("#convertert-capacity-m").text(num / 1000000);
                $("#convertert-capacity-p").text(num / 100000000000);
            };

            let convert2 = function() {
                let inVal = $('#inductance-original-value').val();
                let unitVal = $('#inductance-original-unit').val();
                let num = 0;

                if (unitVal === 'm') {
                    num = Number(inVal) * 1000000;
                } else if(unitVal === 'mm') {
                    num = Number(inVal) * 1000;
                } else if (unitVal === 'n') {
                    num = Number(inVal) * 1000000000;
                }

                $("#convert-inductance-mm").text(num / 1000);
                $("#convert-inductance-n").text(num / 1000000000);
            };

            $("#capacity-original-value").change(convert);
            $("#capacity-original-unit").change(convert);
            $("#inductance-original-value").change(convert2);
            $("#inductance-original-unit").change(convert2);
        });

    </script>

@endsection

