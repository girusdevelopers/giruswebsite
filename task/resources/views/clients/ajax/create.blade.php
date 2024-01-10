@php
$addClientCategoryPermission = user()->permission('manage_client_category');
$addClientSubCategoryPermission = user()->permission('manage_client_subcategory');
$addClientNotePermission = user()->permission('add_client_note');
$addPermission = user()->permission('add_clients');
@endphp

<link rel="stylesheet" href="{{ asset('vendor/css/dropzone.min.css') }}">

<div class="row">
    <div class="col-sm-12">
        <x-form id="save-client-data-form">

            <div class="add-client bg-white rounded">
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.employees.accountDetails')</h4>

                @if (isset($lead->id)) <input type="hidden" name="lead"
                        value="{{ $lead->id }}"> @endif

                <div class="row p-20">
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-4">
                                <x-forms.select fieldId="salutation" fieldName="salutation"
                                    :fieldLabel="__('modules.client.salutation')">
                                    <option value="">--</option>
                                    @foreach ($salutations as $salutation)
                                        <option value="{{ $salutation }}">@lang('app.'.$salutation)</option>
                                    @endforeach
                                </x-forms.select>
                            </div>
                            <div class="col-md-4">
                                <x-forms.text fieldId="name" :fieldLabel="__('modules.client.clientName')" fieldName="name"
                                    fieldRequired="true" :fieldPlaceholder="__('placeholders.name')"
                                    :fieldValue="$lead->client_name ?? ''"></x-forms.text>
                            </div>
                            <div class="col-md-4">
                                <x-forms.email fieldId="email" :fieldLabel="__('app.email')" fieldName="email"
                                    :popover="__('modules.client.emailNote')" :fieldPlaceholder="__('placeholders.email')"
                                    :fieldValue="$lead->client_email ?? ''">
                                </x-forms.email>
                            </div>
                            <div class="col-md-4">
                                <x-forms.label class="mt-3" fieldId="password" :fieldLabel="__('app.password')"
                                    :popover="__('messages.requiredForLogin')">
                                </x-forms.label>
                                <x-forms.input-group>
                                    <input type="password" name="password" id="password" class="form-control height-35 f-14">
                                    <x-slot name="preappend">
                                        <button type="button" data-toggle="tooltip"
                                            data-original-title="@lang('app.viewPassword')"
                                            class="btn btn-outline-secondary border-grey height-35 toggle-password"><i
                                                class="fa fa-eye"></i></button>
                                    </x-slot>
                                    <x-slot name="append">
                                        <button id="random_password" type="button" data-toggle="tooltip"
                                            data-original-title="@lang('modules.client.generateRandomPassword')"
                                            class="btn btn-outline-secondary border-grey height-35"><i
                                                class="fa fa-random"></i></button>
                                    </x-slot>
                                </x-forms.input-group>
                                <small class="form-text text-muted">@lang('placeholders.password')</small>
                            </div>
                            <div class="col-md-4">
                                <x-forms.select fieldId="country" :fieldLabel="__('app.country')" fieldName="country"
                                    search="true">
                                    <option value="">--</option>
                                    @foreach ($countries as $item)
                                        <option @if (isset($lead) && $lead->country == $item->nicename) selected @endif data-tokens="{{ $item->iso3 }}"
                                            data-content="<span class='flag-icon flag-icon-{{ strtolower($item->iso) }} flag-icon-squared'></span> {{ $item->nicename }}"
                                            value="{{ $item->id }}">{{ $item->nicename }}</option>
                                    @endforeach
                                </x-forms.select>
                            </div>
                            <div class="col-md-4">
                                <x-forms.tel fieldId="mobile" :fieldLabel="__('app.mobile')" fieldName="mobile"
                                   :fieldPlaceholder="__('placeholders.mobile')" :fieldValue="$lead->mobile ?? ''"></x-forms.tel>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <x-forms.file allowedFileExtensions="png jpg jpeg svg" class="mr-0 mr-lg-2 mr-md-2 cropper"
                            :fieldLabel="__('modules.profile.profilePicture')" fieldName="image" fieldId="image"
                            fieldHeight="119" :popover="__('messages.fileFormat.ImageFile')" />
                    </div>

                    <div class="col-md-3">
                        <x-forms.select fieldId="gender" :fieldLabel="__('modules.employees.gender')"
                            fieldName="gender">
                            <option value="">--</option>
                            <option value="male">@lang('app.male')</option>
                            <option value="female">@lang('app.female')</option>
                            <option value="others">@lang('app.others')</option>
                        </x-forms.select>
                    </div>

                    <div class="col-md-3">
                        <x-forms.select fieldId="locale" :fieldLabel="__('modules.accountSettings.changeLanguage')"
                            fieldName="locale" search="true">
                            @foreach ($languages as $language)
                                <option {{ user()->locale == $language->language_code ? 'selected' : '' }}
                                data-content="<span class='flag-icon flag-icon-{{ ($language->flag_code == 'en') ? 'gb' : strtolower($language->flag_code) }} flag-icon-squared'></span> {{ $language->language_name }}"
                                value="{{ $language->language_code }}">{{ $language->language_name }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>

                    <div class="col-md-3">
                        <x-forms.label class="mt-3" fieldId="category"
                            :fieldLabel="__('modules.client.clientCategory')">
                        </x-forms.label>
                        <x-forms.input-group>
                            <select class="form-control select-picker" name="category_id" id="category_id"
                                data-live-search="true">
                                <option value="">--</option>
                                @foreach ($categories as $category)
                                    <option @if (isset($lead) && $lead->category_id == $category->id) selected @endif value="{{ $category->id }}">
                                  {{ $category->category_name }}</option>
                                @endforeach
                            </select>

                            @if ($addClientCategoryPermission == 'all')
                                <x-slot name="append">
                                    <button id="addClientCategory" type="button"
                                        class="btn btn-outline-secondary border-grey"
                                        data-toggle="tooltip" data-original-title="{{ __('app.add').' '.__('modules.client.clientCategory') }}">
                                        @lang('app.add')</button>
                                </x-slot>
                            @endif
                        </x-forms.input-group>
                    </div>

                    <div class="col-md-3">
                        <x-forms.label class="mt-3" fieldId="sub_category_id"
                            :fieldLabel="__('modules.client.clientSubCategory')"></x-forms.label>
                        <x-forms.input-group>
                            <select class="form-control select-picker" name="sub_category_id" id="sub_category_id"
                                data-live-search="true">
                                <option value="">--</option>
                            </select>

                            @if ($addClientSubCategoryPermission == 'all')
                                <x-slot name="append">
                                    <button id="addClientSubCategory" type="button"
                                        class="btn btn-outline-secondary border-grey"
                                        data-toggle="tooltip" data-original-title="{{ __('app.add').' '.__('modules.client.clientSubCategory') }}"
                                        >@lang('app.add')</button>
                                </x-slot>
                            @endif
                        </x-forms.input-group>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100 mt-3"
                                for="usr">@lang('modules.client.clientCanLogin')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="login-yes" :fieldLabel="__('app.yes')" fieldName="login"
                                    fieldValue="enable">
                                </x-forms.radio>
                                <x-forms.radio fieldId="login-no" :fieldLabel="__('app.no')" fieldValue="disable"
                                    fieldName="login" checked="true"></x-forms.radio>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100 mt-3"
                                for="usr">@lang('modules.emailSettings.emailNotifications')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="notification-yes" :fieldLabel="__('app.yes')" fieldValue="yes"
                                    fieldName="sendMail" checked="true">
                                </x-forms.radio>
                                <x-forms.radio fieldId="notification-no" :fieldLabel="__('app.no')" fieldValue="no"
                                    fieldName="sendMail">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>


                </div>

                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-top-grey">
                    @lang('modules.client.companyDetails')</h4>
                <div class="row p-20">
                    <div class="col-md-4">
                        <x-forms.text class="mb-3 mt-3 mt-lg-0 mt-md-0" fieldId="company_name"
                            :fieldLabel="__('modules.client.companyName')" fieldName="company_name"
                            :fieldPlaceholder="__('placeholders.company')" :fieldValue="$lead->company_name ?? ''">
                        </x-forms.text>
                    </div>
                    <div class="col-md-4">
                        <x-forms.text class="mb-3 mt-3 mt-lg-0 mt-md-0" fieldId="website"
                            :fieldLabel="__('modules.client.website')" fieldName="website"
                            fieldPlaceholder="e.g. https://www.spacex.com/" :fieldValue="$lead->website ?? ''">
                        </x-forms.text>
                    </div>
                    <div class="col-md-4">
                        <x-forms.text class="mb-3 mt-3 mt-lg-0 mt-md-0" fieldId="gst_number"
                            :fieldLabel="__('app.gstNumber')" fieldName="gst_number"
                            fieldPlaceholder="e.g. 18AABCU960XXXXX" :fieldValue="$lead->gst_number ?? ''">
                        </x-forms.text>
                    </div>

                    <div class="col-md-3">
                        <x-forms.text fieldId="office" :fieldLabel="__('modules.client.officePhoneNumber')"
                            fieldName="office" fieldPlaceholder="e.g. +19876543" :fieldValue="$lead->office ?? ''">
                        </x-forms.text>
                    </div>
                    <div class="col-md-3">
                        <x-forms.text fieldId="city" :fieldLabel="__('modules.stripeCustomerAddress.city')"
                            fieldName="city" fieldPlaceholder="e.g. Hawthorne" :fieldValue="$lead->city ?? ''">
                        </x-forms.text>
                    </div>
                    <div class="col-md-3">
                        <x-forms.text fieldId="state" :fieldLabel="__('modules.stripeCustomerAddress.state')"
                            fieldName="state" fieldPlaceholder="e.g. California" :fieldValue="$lead->state ?? ''">
                        </x-forms.text>
                    </div>
                    <div class="col-md-3">
                        <x-forms.text fieldId="postalCode" :fieldLabel="__('modules.stripeCustomerAddress.postalCode')"
                            fieldName="postal_code" fieldPlaceholder="e.g. 90250"
                            :fieldValue="$lead->postal_code ?? ''">
                        </x-forms.text>
                    </div>

                    @if ($addPermission == 'all')
                        <div class="col-lg-6 col-md-6">
                            <x-forms.select fieldId="added_by" :fieldLabel="__('app.added').' '.__('app.by')"
                                fieldName="added_by">
                                <option value="">--</option>
                                @foreach ($employees as $item)
                                    <x-user-option :user="$item" :selected="user()->id == $item->id" />
                                @endforeach
                            </x-forms.select>
                        </div>
                    @endif
                    <div class="col-md-12">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group my-3">
                            <x-forms.textarea class="mr-0 mr-lg-2 mr-md-2"
                                :fieldLabel="__('modules.accountSettings.companyAddress')" fieldName="address"
                                fieldId="address" fieldPlaceholder="e.g. Rocket Road"
                                :fieldValue="$lead->address ?? ''">
                            </x-forms.textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group my-3">
                            <x-forms.textarea class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('app.shippingAddress')"
                                fieldName="shipping_address" fieldId="shipping_address"
                                fieldPlaceholder="e.g. Rocket Road" :fieldValue="$lead->shipping_address ?? ''">
                            </x-forms.textarea>
                        </div>
                    </div>

                    @if (function_exists('sms_setting') && sms_setting()->telegram_status)
                        <div class="col-md-4">
                            <x-forms.number fieldName="telegram_user_id" fieldId="telegram_user_id"
                                fieldLabel="<i class='fab fa-telegram'></i> {{ __('sms::modules.telegramUserId') }}"
                                :popover="__('sms::modules.userIdInfo')" />
                        </div>
                    @endif

                    @if ($addClientNotePermission == 'all' || $addClientNotePermission == 'added' || $addClientNotePermission == 'both')
                    <div class="col-md-12">
                        <div class="form-group my-3">
                            <x-forms.label class="my-3" fieldId="note" :fieldLabel="__('app.note')">
                            </x-forms.label>
                            <div id="note"></div>
                            <textarea name="note" id="note-text" class="d-none"></textarea>
                        </div>
                    </div>
                    @endif

                    <div class="col-lg-12">
                        <x-forms.file allowedFileExtensions="png jpg jpeg svg" class="mr-0 mr-lg-2 mr-md-2"
                                               :fieldLabel="__('modules.contracts.companyLogo')" fieldName="company_logo"
                                               :fieldValue="(company()->logo_url)" fieldId="company_logo" :popover="__('messages.fileFormat.ImageFile')"/>
                    </div>

                    <input type ="hidden" name="add_more" value="false" id="add_more" />

                </div>

                <x-forms.custom-field :fields="$fields"></x-forms.custom-field>

                <x-form-actions>
                    <x-forms.button-primary id="save-client-form" class="mr-3" icon="check">@lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-secondary class="mr-3" id="save-more-client-form" icon="check-double">@lang('app.saveAddMore')
                    </x-forms.button-secondary>
                    <x-forms.button-cancel :link="route('clients.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                </x-form-actions>
            </div>
        </x-form>

    </div>
</div>

<script src="{{ asset('vendor/jquery/dropzone.min.js') }}"></script>
<script>
    var add_client_note_permission = "{{  $addClientNotePermission }}";

    $(document).ready(function() {
        if ($('.custom-date-picker').length > 0) {
            datepicker('.custom-date-picker', {
                position: 'bl',
                ...datepickerConfig
            });
        }

        if(add_client_note_permission == 'all' || add_client_note_permission == 'added' || add_client_note_permission == 'both')
        {
            quillImageLoad('#note');
        }

        $('#category_id').change(function(e) {

            let categoryId = $(this).val();

            var url = "{{ route('get_client_sub_categories', ':id') }}";
            url = url.replace(':id', categoryId);

            $.easyAjax({
                url: url,
                type: "GET",
                success: function(response) {
                    if (response.status == 'success') {
                        var options = [];
                        var rData = [];
                        rData = response.data;
                        $.each(rData, function(index, value) {
                            var selectData = '';
                            selectData = '<option value="' + value.id + '">' + value
                                .category_name + '</option>';
                            options.push(selectData);
                        });

                        $('#sub_category_id').html('<option value="">--</option>' +
                            options);
                        $('#sub_category_id').selectpicker('refresh');
                    }
                }
            })

        });

        $('#save-more-client-form').click(function () {

            $('#add_more').val(true);

            if(add_client_note_permission == 'all' || add_client_note_permission == 'added' || add_client_note_permission == 'both')
            {
                var note = document.getElementById('note').children[0].innerHTML;
                document.getElementById('note-text').value = note;
            }

            const url = "{{ route('clients.store') }}";
            // var data = $('#save-client-data-form').serialize() + '&add_more=true';
            var data = $('#save-client-data-form').serialize();

            // console.log(data);
            saveClient(data, url, "#save-more-client-form");

        });

        $('#save-client-form').click(function() {
            if(add_client_note_permission == 'all' || add_client_note_permission == 'added' || add_client_note_permission == 'both')
            {
                var note = document.getElementById('note').children[0].innerHTML;
                document.getElementById('note-text').value = note;
            }

            const url = "{{ route('clients.store') }}";
            var data = $('#save-client-data-form').serialize();

            saveClient(data, url, "#save-client-form");

        });

        function saveClient(data, url, buttonSelector) {
            $.easyAjax({
                url: url,
                container: '#save-client-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: buttonSelector,
                file: true,
                data: data,
                success: function(response) {
                    if (response.status == 'success') {
                        if ($(MODAL_XL).hasClass('show')) {

                            $(MODAL_XL).modal('hide');
                            window.location.reload();
                        } else if(typeof response.redirectUrl !== 'undefined'){
                            window.location.href = response.redirectUrl;
                        }
                        else if(response.add_more == true) {

                            var right_modal_content = $.trim($(RIGHT_MODAL_CONTENT).html());
                            if(right_modal_content.length) {

                                $(RIGHT_MODAL_CONTENT).html(response.html.html);
                                $('#add_more').val(false);
                            }
                            else {

                                $('.content-wrapper').html(response.html.html);
                                init('.content-wrapper');
                                $('#add_more').val(false);
                            }
                        }

                        if (typeof showTable !== 'undefined' && typeof showTable === 'function') {
                            showTable();
                        }
                    }
                }
            });
        }

        $('#random_password').click(function() {
            const randPassword = Math.random().toString(36).substr(2, 8);

            $('#password').val(randPassword);
        });

        $('#addClientCategory').click(function() {
            const url = "{{ route('clientCategory.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        })
        $('#addClientSubCategory').click(function() {
            const url = "{{ route('clientSubCategory.create') }}";
            $(MODAL_LG + ' ' + MODAL_HEADING).html('...');
            $.ajaxModal(MODAL_LG, url);
        });

        init(RIGHT_MODAL);
    });

    function checkboxChange(parentClass, id) {
        var checkedData = '';
        $('.' + parentClass).find("input[type= 'checkbox']:checked").each(function() {
            checkedData = (checkedData !== '') ? checkedData + ', ' + $(this).val() : $(this).val();
        });
        $('#' + id).val(checkedData);
    }
</script>
