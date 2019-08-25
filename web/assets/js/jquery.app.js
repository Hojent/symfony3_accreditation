(function($){
    'use strict';

    function initNavbar () {
        $('.navbar-toggle').on('click', function(event) {
            $(this).toggleClass('open');
            $('#navigation').slideToggle(400);
        });

        $('.navigation-menu>li').slice(-1).addClass('last-elements');

        $('.navigation-menu li.has-submenu a[href="#"]').on('click', function(e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
            }
        });
    }

    function handleRestoreLeadForm() {
        var autoEmailField = $('input[name="lead_restore[autoEmail]"]');
        var toRemarketingField = $('input[name="lead_restore[toRemarketing]"]');
        var restoredButton = $('button[name="lead_restore[restore]"]');
        var countrySelect = $('select[name="lead_restore[country]"]');
        var countrySelect2 = $('select[name="lead_restore[country2]"]');
        var ignoreInvalidPhoneField = $('input[name="lead_restore[ignoreInvalidPhone]"]');

        var restoredButtonBlock = restoredButton.parent().parent();
        var toRemarketingFieldBlock = toRemarketingField.parent();
        var autoEmailFieldBlock = autoEmailField.parent();
        var emailFieldBlock = $('input[name="lead_restore[email]"]').parent();
        var ignoreInvalidPhoneFieldBlock = ignoreInvalidPhoneField.parent();
        var toggleSpeed = 'fast';

        var toggleEmailFieldBlock = function(element) {
            if (element.prop('checked')) {
                emailFieldBlock.hide(toggleSpeed);
                toRemarketingFieldBlock.hide(toggleSpeed);
            } else {
                emailFieldBlock.show(toggleSpeed);
                toRemarketingFieldBlock.show(toggleSpeed);
            }
        };

        var toggleToRemarktingFieldBlock = function(element) {
            if (element.prop('checked')) {
                autoEmailFieldBlock.hide(toggleSpeed);
                restoredButtonBlock.hide(toggleSpeed);
                ignoreInvalidPhoneFieldBlock.hide(toggleSpeed);
            } else {
                autoEmailFieldBlock.show(toggleSpeed);
                restoredButtonBlock.show(toggleSpeed);
                ignoreInvalidPhoneFieldBlock.show(toggleSpeed);
            }
        };

        toggleEmailFieldBlock(autoEmailField);
        toggleToRemarktingFieldBlock(toRemarketingField);

        autoEmailField.change(function() {
            toggleEmailFieldBlock($(this));
        });
        toRemarketingField.change(function() {
            toggleToRemarktingFieldBlock($(this));
        });

        countrySelect.change(function(e) {
            var phoneCode = $('option:selected', this).attr('data-phoneCode');

            $('#phoneCodeLabel').html(phoneCode);
            $('input[name="lead_restore[phoneCode]"]').val(phoneCode);
        });
        
        countrySelect2.change(function(e) {
            var phoneCode = $('option:selected', this).attr('data-phoneCode2');

            $('#phoneCodeLabel2').html(phoneCode);
            $('input[name="lead_restore[phoneCode2]"]').val(phoneCode);
        });
    }

    function initDatepicker() {
        $('[data-type=datepicker]').datepicker({
            format: 'yyyy-mm-dd',
            orientation: "top"
        });
    }

    function initLandingPage() {
        var landingGraphs = $('div[id^=landingGraph]');

        if (landingGraphs.length) {
            $.each(landingGraphs, function(index, value){
                var graph = $(value);

                $.post('/landing/ajax-graph-' + graph.data('landing-id') + '.json', function(data) {
                    graph.data('fill', ['#00b19d', '#3ddcf7']);
                    graph.data('stroke', '#ebeff2');
                    graph.data('width', '120');
                    graph.data('height', '17');
                    graph.html(data.values.join(','));

                    graph.peity("bar", graph.data());
                }, 'json');
            });
        }
    }

    function handleCreateCriteriaForm() {
        var selectField = $('select[name="create_limitation_criteria[type]"]');
        var options = $('select.js-criteria_type');

        selectField.change(function(){
            options.each(function(){
                $(this).parent().addClass('hidden');
                $(this).removeAttr('required');
            })
            var neededElement = $('#create_limitation_criteria_type_data_'+ selectField.val());
            neededElement.parent().removeClass('hidden');
            neededElement.attr('required','required');
        });
        selectField.change();
    }
    
    function handleSourceFilterForm() {
        var source =   $('select.js-utm_filter_source');
        var medium =   $('select.js-utm_filter_medium');
        var campaign = $('select.js-utm_filter_campaign');
        var ad =       $('select.js-utm_filter_ad');
        var creative = $('select.js-utm_filter_creative');

        var fields = [source, medium, campaign, ad, creative];

        function checkHidden() {

            var hideCurrent = false;
            var hideNext = true;

            fields.forEach(function(field,i) {
                var current = field;
                var parent = current.parent();
                while(parent.find('.js-utm_filter').length == 1) {
                        current = parent;
                        parent = parent.parent();
                }
                if(hideCurrent) {
                    parent.addClass('hidden');
                    field.val('');
                } else {
                    parent.removeClass('hidden');
                }

                if(field.val() == "") {
                    hideNext = true && hideNext;
                    hideCurrent = hideNext;
                }
            });
        }

        $('.js-utm_filter_source').change(function(){
            if($(this).val() != '') {
                medium.val('');
                medium.attr('disabled','disabled');
                checkHidden();
                $.ajax({
                    url: "/ajax/utm_data/get_mediums/"+$(this).val(),
                    context: medium,
                    dataType: "json"
                }).done(function(data) {
                    var option = $(this).children('option').first().clone();
                    $(this).empty().append(option);
                    data.forEach(function(item){
                       $('<option/>', {'value' : item.hash}).append(item.name).insertAfter(option);
                    });
                    $(this).removeAttr('disabled');
                });
            }
            checkHidden();
        })

        $('.js-utm_filter_medium').change(function(){
            if($(this).val() != '') {
                campaign.val('');
                campaign.attr('disabled','disabled');
                checkHidden();
                $.ajax({
                    url: "/ajax/utm_data/get_campaigns/"+$(this).val(),
                    context: campaign,
                    dataType: "json"
                }).done(function(data) {
                    var option = $(this).children('option').first().clone();
                    $(this).empty().append(option);
                    data.forEach(function(item){
                       $('<option/>', {'value' : item.hash}).append(item.name).insertAfter(option);
                    });
                    $(this).removeAttr('disabled');
                });
            }
            checkHidden();
        })

        $('.js-utm_filter_campaign').change(function(){
            if($(this).val() != '') {
                ad.val('');
                ad.attr('disabled','disabled');
                checkHidden();
                $.ajax({
                    url: "/ajax/utm_data/get_ads/"+$(this).val(),
                    context: ad,
                    dataType: "json"
                }).done(function(data) {
                    var option = $(this).children('option').first().clone();
                    $(this).empty().append(option);
                    data.forEach(function(item){
                       $('<option/>', {'value' : item.hash}).append(item.name).insertAfter(option);
                    });
                    $(this).removeAttr('disabled');
                });
            }
            checkHidden();
        })

        $('.js-utm_filter_ad').change(function(){
            if($(this).val() != '') {
                creative.val('');
                creative.attr('disabled','disabled');
                checkHidden();
                $.ajax({
                    url: "/ajax/utm_data/get_creatives/"+$(this).val(),
                    context: creative,
                    dataType: "json"
                }).done(function(data) {
                    var option = $(this).children('option').first().clone();
                    $(this).empty().append(option);
                    data.forEach(function(item){
                       $('<option/>', {'value' : item.hash}).append(item.name).insertAfter(option);
                    });
                    $(this).removeAttr('disabled');
                });
            }
            checkHidden();
        })

        checkHidden();
    }
    
    function handleUserForm() {
        var rolesFieldId = 'select.js-user-roles';
        var select2Field = $(rolesFieldId).first().select2();

        var sourcesFieldId = '.js-user-allowed-sources';
        var callCenterFieldId = '.js-user-allowed-callCenters';

        function showSourcesByRoles(roles,allowedForRoles, id) {
            $(id).parent().hide();
            if(roles == null) return;
            for(var i=0; i<roles.length;i++) {
                if($.inArray(roles[i], allowedForRoles) != -1){
                    $(id).parent().show();
                }
            }
        }
        showSourcesByRoles($(rolesFieldId).val(), $(sourcesFieldId).data('roles'), sourcesFieldId);
        showSourcesByRoles($(rolesFieldId).val(), $(callCenterFieldId).data('roles'), callCenterFieldId);

        select2Field.on("change", function(e) {
            showSourcesByRoles(e.val, $(sourcesFieldId).data('roles'), sourcesFieldId);
            showSourcesByRoles(e.val, $(callCenterFieldId).data('roles'), callCenterFieldId);
        });
    }

    function init () {
        initNavbar();
        handleRestoreLeadForm();
        initDatepicker();
        initLandingPage();
        handleCreateCriteriaForm();
        handleSourceFilterForm();
        handleUserForm();

        $('.circliful-chart').circliful();
    }

    jQuery(document).ready(function($) {
        init();
    });
})(jQuery);
