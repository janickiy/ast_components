@extends('layouts.frontend')

@section('title', $title)

@section('description', $meta_description)

@section('keywords', $meta_keywords)

@section('seo_url_canonical', $seo_url_canonical)

@section('css')

@endsection

@section('content')

    <div class="page-header container-lg">
        <div class="page-header__wrap">

            @include('layouts._breadcrumbs')

            <h1>{{ $h1 }}</h1>

        </div>
    </div>

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
                        <label for="inductance-original-value">Введите исходное значение</label>
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

    <script>
        const inVal = document.getElementById('capacity-original-value');
        const unitVal = document.getElementById('capacity-original-unit');
        const capacityM = document.getElementById('convertert-capacity-m');
        const capacityP = document.getElementById('convertert-capacity-p');

        const inVal2 = document.getElementById('inductance-original-value');
        const unitVal2 = document.getElementById('inductance-original-unit');
        const inductanceValue = document.getElementById('convert-inductance-mm');
        const inductanceUnit = document.getElementById('convert-inductance-n');

        inVal.addEventListener('input', function() {
            showResult1(inVal,unitVal,capacityM,capacityP);
        });

        unitVal.addEventListener('change', function() {
            showResult1(inVal,unitVal,capacityM,capacityP);
        });

        inVal2.addEventListener('input', function() {
            showResult2(inVal2,unitVal2,inductanceValue,inductanceUnit);
        });

        unitVal2.addEventListener('change', function() {
            showResult2(inVal2,unitVal2,inductanceValue,inductanceUnit);
        });

        function showResult1(inVal,unitVal,M,P) {
            const inValValue = inVal.value;

            if (inValValue !== '' && !isNaN(inValValue)) {
                const unitValValue = unitVal.value;
                let num = 0;

                if (unitValValue === 'n') {
                    num = Number(inValValue) * 1000000000;
                } else if(unitValValue === 'm') {
                    num = Number(inValValue) * 1000000;
                } else if (unitValValue === 'p') {
                    num = Number(inValValue) * 100000000000;
                }

                M.textContent = num / 1000000;
                P.textContent = num / 100000000000;
            }
        }

        function showResult2(inVal2,unitVal2,V,U) {
            const inValValue = inVal2.value;

            if (inValValue !== '' && !isNaN(inValValue)) {
                const unitValValue = unitVal2.value;
                let num = 0;

                if (unitValValue === 'm') {
                    num = Number(inValValue) * 1000000;
                } else if(unitValValue === 'mm') {
                    num = Number(inValValue) * 1000;
                } else if (unitValValue === 'n') {
                    num = Number(inValValue) * 1000000000;
                }

                V.textContent = num / 1000000;
                U.textContent = num / 1000000000;
            }
        }

    </script>

@endsection

