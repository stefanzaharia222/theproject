@php
    $configData = Helper::appClasses();

@endphp
@extends('layouts.layoutMaster')
@section('title', 'STATUS')

@section('vendor-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
@endsection

<!-- Page -->
@section('page-style')
@endsection


@section('vendor-script')
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
@endsection

@section('page-script')
    <script>
        // Define a JavaScript variable with the app locale value
        var appLocale = "{{ config('app.locale') }}";
    </script>
    <script src="{{ (asset('./js/custom-datatables.js')) }}"></script>
    <script src="{{asset('assets/js/forms-tagify.js')}}"></script>

@endsection

@section('content')
    @include('pages.partials.tabs.tabs', [
        'tabName' => 'process',
        'data' => $process,
        'data_deleted' => $process_deleted,
        'columns' => [
            '',
            'id',
            'name',
            'user',
            'entity',
            'tag',
            'created_at',
            'updated_at',
            'deleted_at',
        ]
    ])

    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

    <script>
        let countryRender = {
            countries: [
                {code: 'AF', name: 'Afghanistan'},
                {code: 'AX', name: 'Aland Islands'},
                {code: 'AL', name: 'Albania'},
                {code: 'DZ', name: 'Algeria'},
                {code: 'AS', name: 'American Samoa'},
                {code: 'AD', name: 'Andorra'},
                {code: 'AO', name: 'Angola'},
                {code: 'AI', name: 'Anguilla'},
                {code: 'AQ', name: 'Antarctica'},
                {code: 'AG', name: 'Antigua And Barbuda'},
                {code: 'AR', name: 'Argentina'},
                {code: 'AM', name: 'Armenia'},
                {code: 'AW', name: 'Aruba'},
                {code: 'AU', name: 'Australia'},
                {code: 'AT', name: 'Austria'},
                {code: 'AZ', name: 'Azerbaijan'},
                {code: 'BS', name: 'Bahamas'},
                {code: 'BH', name: 'Bahrain'},
                {code: 'BD', name: 'Bangladesh'},
                {code: 'BB', name: 'Barbados'},
                {code: 'BY', name: 'Belarus'},
                {code: 'BE', name: 'Belgium'},
                {code: 'BZ', name: 'Belize'},
                {code: 'BJ', name: 'Benin'},
                {code: 'BM', name: 'Bermuda'},
                {code: 'BT', name: 'Bhutan'},
                {code: 'BO', name: 'Bolivia'},
                {code: 'BA', name: 'Bosnia And Herzegovina'},
                {code: 'BW', name: 'Botswana'},
                {code: 'BV', name: 'Bouvet Island'},
                {code: 'BR', name: 'Brazil'},
                {code: 'IO', name: 'British Indian Ocean Territory'},
                {code: 'BN', name: 'Brunei Darussalam'},
                {code: 'BG', name: 'Bulgaria'},
                {code: 'BF', name: 'Burkina Faso'},
                {code: 'BI', name: 'Burundi'},
                {code: 'KH', name: 'Cambodia'},
                {code: 'CM', name: 'Cameroon'},
                {code: 'CA', name: 'Canada'},
                {code: 'CV', name: 'Cape Verde'},
                {code: 'KY', name: 'Cayman Islands'},
                {code: 'CF', name: 'Central African Republic'},
                {code: 'TD', name: 'Chad'},
                {code: 'CL', name: 'Chile'},
                {code: 'CN', name: 'China'},
                {code: 'CX', name: 'Christmas Island'},
                {code: 'CC', name: 'Cocos (Keeling) Islands'},
                {code: 'CO', name: 'Colombia'},
                {code: 'KM', name: 'Comoros'},
                {code: 'CG', name: 'Congo'},
                {code: 'CD', name: 'Congo}, Democratic Republic'},
                {code: 'CK', name: 'Cook Islands'},
                {code: 'CR', name: 'Costa Rica'},
                {code: 'CI', name: 'Cote D\'Ivoire'},
                {code: 'HR', name: 'Croatia'},
                {code: 'CU', name: 'Cuba'},
                {code: 'CY', name: 'Cyprus'},
                {code: 'CZ', name: 'Czech Republic'},
                {code: 'DK', name: 'Denmark'},
                {code: 'DJ', name: 'Djibouti'},
                {code: 'DM', name: 'Dominica'},
                {code: 'DO', name: 'Dominican Republic'},
                {code: 'EC', name: 'Ecuador'},
                {code: 'EG', name: 'Egypt'},
                {code: 'SV', name: 'El Salvador'},
                {code: 'GQ', name: 'Equatorial Guinea'},
                {code: 'ER', name: 'Eritrea'},
                {code: 'EE', name: 'Estonia'},
                {code: 'ET', name: 'Ethiopia'},
                {code: 'FK', name: 'Falkland Islands (Malvinas)'},
                {code: 'FO', name: 'Faroe Islands'},
                {code: 'FJ', name: 'Fiji'},
                {code: 'FI', name: 'Finland'},
                {code: 'FR', name: 'France'},
                {code: 'GF', name: 'French Guiana'},
                {code: 'PF', name: 'French Polynesia'},
                {code: 'TF', name: 'French Southern Territories'},
                {code: 'GA', name: 'Gabon'},
                {code: 'GM', name: 'Gambia'},
                {code: 'GE', name: 'Georgia'},
                {code: 'DE', name: 'Germany'},
                {code: 'GH', name: 'Ghana'},
                {code: 'GI', name: 'Gibraltar'},
                {code: 'GR', name: 'Greece'},
                {code: 'GL', name: 'Greenland'},
                {code: 'GD', name: 'Grenada'},
                {code: 'GP', name: 'Guadeloupe'},
                {code: 'GU', name: 'Guam'},
                {code: 'GT', name: 'Guatemala'},
                {code: 'GG', name: 'Guernsey'},
                {code: 'GN', name: 'Guinea'},
                {code: 'GW', name: 'Guinea-Bissau'},
                {code: 'GY', name: 'Guyana'},
                {code: 'HT', name: 'Haiti'},
                {code: 'HM', name: 'Heard Island & Mcdonald Islands'},
                {code: 'VA', name: 'Holy See (Vatican City State)'},
                {code: 'HN', name: 'Honduras'},
                {code: 'HK', name: 'Hong Kong'},
                {code: 'HU', name: 'Hungary'},
                {code: 'IS', name: 'Iceland'},
                {code: 'IN', name: 'India'},
                {code: 'ID', name: 'Indonesia'},
                {code: 'IR', name: 'Iran}, Islamic Republic Of'},
                {code: 'IQ', name: 'Iraq'},
                {code: 'IE', name: 'Ireland'},
                {code: 'IM', name: 'Isle Of Man'},
                {code: 'IL', name: 'Israel'},
                {code: 'IT', name: 'Italy'},
                {code: 'JM', name: 'Jamaica'},
                {code: 'JP', name: 'Japan'},
                {code: 'JE', name: 'Jersey'},
                {code: 'JO', name: 'Jordan'},
                {code: 'KZ', name: 'Kazakhstan'},
                {code: 'KE', name: 'Kenya'},
                {code: 'KI', name: 'Kiribati'},
                {code: 'KR', name: 'Korea'},
                {code: 'KW', name: 'Kuwait'},
                {code: 'KG', name: 'Kyrgyzstan'},
                {code: 'LA', name: 'Lao People\'s Democratic Republic'},
                {code: 'LV', name: 'Latvia'},
                {code: 'LB', name: 'Lebanon'},
                {code: 'LS', name: 'Lesotho'},
                {code: 'LR', name: 'Liberia'},
                {code: 'LY', name: 'Libyan Arab Jamahiriya'},
                {code: 'LI', name: 'Liechtenstein'},
                {code: 'LT', name: 'Lithuania'},
                {code: 'LU', name: 'Luxembourg'},
                {code: 'MO', name: 'Macao'},
                {code: 'MK', name: 'Macedonia'},
                {code: 'MG', name: 'Madagascar'},
                {code: 'MW', name: 'Malawi'},
                {code: 'MY', name: 'Malaysia'},
                {code: 'MV', name: 'Maldives'},
                {code: 'ML', name: 'Mali'},
                {code: 'MT', name: 'Malta'},
                {code: 'MH', name: 'Marshall Islands'},
                {code: 'MQ', name: 'Martinique'},
                {code: 'MR', name: 'Mauritania'},
                {code: 'MU', name: 'Mauritius'},
                {code: 'YT', name: 'Mayotte'},
                {code: 'MX', name: 'Mexico'},
                {code: 'FM', name: 'Micronesia}, Federated States Of'},
                {code: 'MD', name: 'Moldova'},
                {code: 'MC', name: 'Monaco'},
                {code: 'MN', name: 'Mongolia'},
                {code: 'ME', name: 'Montenegro'},
                {code: 'MS', name: 'Montserrat'},
                {code: 'MA', name: 'Morocco'},
                {code: 'MZ', name: 'Mozambique'},
                {code: 'MM', name: 'Myanmar'},
                {code: 'NA', name: 'Namibia'},
                {code: 'NR', name: 'Nauru'},
                {code: 'NP', name: 'Nepal'},
                {code: 'NL', name: 'Netherlands'},
                {code: 'NC', name: 'New Caledonia'},
                {code: 'NZ', name: 'New Zealand'},
                {code: 'NI', name: 'Nicaragua'},
                {code: 'NE', name: 'Niger'},
                {code: 'NG', name: 'Nigeria'},
                {code: 'NU', name: 'Niue'},
                {code: 'NF', name: 'Norfolk Island'},
                {code: 'MP', name: 'Northern Mariana Islands'},
                {code: 'NO', name: 'Norway'},
                {code: 'OM', name: 'Oman'},
                {code: 'PK', name: 'Pakistan'},
                {code: 'PW', name: 'Palau'},
                {code: 'PS', name: 'Palestinian Territory}, Occupied'},
                {code: 'PA', name: 'Panama'},
                {code: 'PG', name: 'Papua New Guinea'},
                {code: 'PY', name: 'Paraguay'},
                {code: 'PE', name: 'Peru'},
                {code: 'PH', name: 'Philippines'},
                {code: 'PN', name: 'Pitcairn'},
                {code: 'PL', name: 'Poland'},
                {code: 'PT', name: 'Portugal'},
                {code: 'PR', name: 'Puerto Rico'},
                {code: 'QA', name: 'Qatar'},
                {code: 'RE', name: 'Reunion'},
                {code: 'RO', name: 'Romania'},
                {code: 'RU', name: 'Russian Federation'},
                {code: 'RW', name: 'Rwanda'},
                {code: 'BL', name: 'Saint Barthelemy'},
                {code: 'SH', name: 'Saint Helena'},
                {code: 'KN', name: 'Saint Kitts And Nevis'},
                {code: 'LC', name: 'Saint Lucia'},
                {code: 'MF', name: 'Saint Martin'},
                {code: 'PM', name: 'Saint Pierre And Miquelon'},
                {code: 'VC', name: 'Saint Vincent And Grenadines'},
                {code: 'WS', name: 'Samoa'},
                {code: 'SM', name: 'San Marino'},
                {code: 'ST', name: 'Sao Tome And Principe'},
                {code: 'SA', name: 'Saudi Arabia'},
                {code: 'SN', name: 'Senegal'},
                {code: 'RS', name: 'Serbia'},
                {code: 'SC', name: 'Seychelles'},
                {code: 'SL', name: 'Sierra Leone'},
                {code: 'SG', name: 'Singapore'},
                {code: 'SK', name: 'Slovakia'},
                {code: 'SI', name: 'Slovenia'},
                {code: 'SB', name: 'Solomon Islands'},
                {code: 'SO', name: 'Somalia'},
                {code: 'ZA', name: 'South Africa'},
                {code: 'GS', name: 'South Georgia And Sandwich Isl.'},
                {code: 'ES', name: 'Spain'},
                {code: 'LK', name: 'Sri Lanka'},
                {code: 'SD', name: 'Sudan'},
                {code: 'SR', name: 'Suriname'},
                {code: 'SJ', name: 'Svalbard And Jan Mayen'},
                {code: 'SZ', name: 'Swaziland'},
                {code: 'SE', name: 'Sweden'},
                {code: 'CH', name: 'Switzerland'},
                {code: 'SY', name: 'Syrian Arab Republic'},
                {code: 'TW', name: 'Taiwan'},
                {code: 'TJ', name: 'Tajikistan'},
                {code: 'TZ', name: 'Tanzania'},
                {code: 'TH', name: 'Thailand'},
                {code: 'TL', name: 'Timor-Leste'},
                {code: 'TG', name: 'Togo'},
                {code: 'TK', name: 'Tokelau'},
                {code: 'TO', name: 'Tonga'},
                {code: 'TT', name: 'Trinidad And Tobago'},
                {code: 'TN', name: 'Tunisia'},
                {code: 'TR', name: 'Turkey'},
                {code: 'TM', name: 'Turkmenistan'},
                {code: 'TC', name: 'Turks And Caicos Islands'},
                {code: 'TV', name: 'Tuvalu'},
                {code: 'UG', name: 'Uganda'},
                {code: 'UA', name: 'Ukraine'},
                {code: 'AE', name: 'United Arab Emirates'},
                {code: 'GB', name: 'United Kingdom'},
                {code: 'US', name: 'United States'},
                {code: 'UM', name: 'United States Outlying Islands'},
                {code: 'UY', name: 'Uruguay'},
                {code: 'UZ', name: 'Uzbekistan'},
                {code: 'VU', name: 'Vanuatu'},
                {code: 'VE', name: 'Venezuela'},
                {code: 'VN', name: 'Viet Nam'},
                {code: 'VG', name: 'Virgin Islands}, British'},
                {code: 'VI', name: 'Virgin Islands}, U.S.'},
                {code: 'WF', name: 'Wallis And Futuna'},
                {code: 'EH', name: 'Western Sahara'},
                {code: 'YE', name: 'Yemen'},
                {code: 'ZM', name: 'Zambia'},
                {code: 'ZW', name: 'Zimbabwe'}
            ],

            showElements: function () {
                // SHOW description and rest of inputs
                $('.add-special_field_option-container').removeClass('d-none')
                $('.field-buttons').removeClass('d-none')
                $('.special_field_option_description').removeClass('d-none')
            },
            hideElements: function () {
                // HIDE description and rest of inputs
                $('.add-special_field_option-container').addClass('d-none')
                $('.field-buttons').addClass('d-none')
                $('.special_field_option_description').addClass('d-none')
            },

            initializeSelect2: function (selectBox, countries) {
                countries.forEach(country => {
                    const option = new Option(country.name, country.code, false, false);
                    selectBox.append(option);
                });

                // Initialize Select2 on the provided select element
                $(selectBox).select2({
                    templateResult: this.formatCountry,
                    templateSelection: this.formatCountry,
                });
            },
            formatCountry: function (country) {
                if (!country.id) {
                    return country.text;
                }
                const url = '{{ asset("flags/4x3") }}' + `/${country.id}.svg`;
                const flagUrl = url.toLowerCase();
                return $(`<span><img src="${flagUrl}" class="flag-icon" /> ${country.text}</span>`);
            },
            hasDuplicateElements: function (arr) {
                return new Set(arr).size !== arr.length;
            },

            addLanguage: function () {
                $('.add-language').click((e) => {
                    e.preventDefault()

                    // Get the parent element (the whole input group)
                    let parentElement = $(e.currentTarget).parent();
                    // Get the label's text by selecting the span with class 'input-group-text'
                    let labelText = parentElement.find('.input-group-text:first').text();

                    const reformatLabelText = labelText.replace(/ /g, "-");

                    this.createAndAppendOuterDiv(reformatLabelText, e)

                    $('.countrySelect').change((e) => {
                        let langCode = $(e.currentTarget).val();
                        let fieldName = $(e.currentTarget).data('name');
                        if (labelText === 'Description') {
                            $(e.currentTarget).parent('div').find('textarea').attr({
                                name: 'input[language][' + langCode + '][' + fieldName.toLowerCase() + '][]'
                            })
                        } else {
                            $(e.currentTarget).parent('div').find('input').attr({
                                name: 'input[language][' + langCode + '][' + fieldName.toLowerCase() + '][]'
                            })
                        }
                    })

                    this.removeLanguage(labelText, parentElement);
                });
            },
            removeLanguage: function (labelText, parentElement) {
                // Event delegation for the click on the .remove-language button
                $(".remove-language").click((e) => {
                    $(e.currentTarget).parent().remove();

                    // check if exist any other, if not able the input
                    if ($('.container-lang-' + labelText.toLowerCase()).length === 0) {
                        parentElement.find('input:first').prop("disabled", false);
                    }
                });
            },

            createAndAppendOuterDiv: function (labelText, e) {
                // Create the outer div element with the specified classes
                let outerDiv = $('<div>').addClass('input-group new-language-input input-group-lg mb-3 container-lang-' + labelText.toLowerCase());

                let span1 = $('<span>').addClass('input-group-text').text(labelText);

                let button = $('<button>').attr('type', 'button').addClass('btn btn-danger remove-language').text('-');

                let newSelect = $('<select>').attr({
                    class: 'countrySelect',
                    placeholder: labelText
                });

                newSelect.attr('data-name', labelText.toLowerCase());

                const firstCountryCode = countryRender.countries[0]?.code;

                if (labelText === 'Description') {
                    let textarea = $('<textarea>')
                    textarea.attr({
                        name: 'input[language][' + firstCountryCode + '][' + labelText.toLowerCase() + '][]',
                        class: 'form-control',
                    })
                    outerDiv.append(span1, textarea, newSelect, button);
                } else {
                    let input = $('<input>')

                    input.attr({
                        type: 'text',
                        name: 'input[language][' + firstCountryCode + '][' + labelText.toLowerCase() + '][]',
                        class: 'form-control',
                        placeholder: labelText,
                    });
                    outerDiv.append(span1, input, newSelect, button);
                }

                $(e.currentTarget).parent().after(outerDiv);

                this.initializeSelect2(newSelect, countryRender.countries)
            },

            submitForm: function () {
                $('#add_item_form').submit((e) => {
                    e.preventDefault()
                    let array = []

                    $('.countrySelect').each(function (index, element) {
                        let nameAttribute = $(element).data('name');
                        let value = $(element).val();

                        let word = nameAttribute + "_" + value;

                        array.push(word)
                    });

                    if (this.hasDuplicateElements(array)) {
                        alert('You have more than one translation for the same language which is not allowed');
                    } else {
                        $('#add_item_form').unbind('submit').submit();
                    }
                });
            }
        }

        countryRender.showElements();
        countryRender.initializeSelect2($('.countrySelect'), countryRender.countries);
        countryRender.addLanguage();
        countryRender.submitForm()
    </script>
@endsection
