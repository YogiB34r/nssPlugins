jQuery(document).ready(function ($) {
    if (document.querySelector('#categoryProductSlider')) {
        var sliderNameData = null;
        $(".sortable").sortable();
        $(".sortable").disableSelection();
        $('#slider-add-button').click(function (e) {
            var sliderNameData = $('.slider-name-input').val().replace(/\s+/g, '-');
            var sliderName =  $('.slider-name-input').val();
            printSliderForm(sliderNameData, sliderName);
            $('.slider-name-input').val('');
        });

        function printSliderForm(sliderNameData, sliderName) {
            if ('content' in document.createElement('template')) {
                var template = document.querySelector('#slider-form-template').content.cloneNode(true);
                template.querySelector('.categorySelect').name = 'gf_category_product_slider_options[sliders][' + sliderName + '][category][id]';
                template.querySelector('.linkInput').name = 'gf_category_product_slider_options[sliders][' + sliderName + '][category][link]';
                template.querySelector('.product-list').dataset.productCount = '0';
                template.querySelector('.product-list').className += '-' + sliderNameData;
                template.querySelector('.slider-heading').innerHTML += sliderNameData.replace(/-/g, ' ');
                template.querySelector('.slider-wrapper').dataset.sliderName = sliderNameData;

                var container = document.querySelector('#forms-container');
                container.on('load', '.sortable', function () {
                    console.log('caooooo');
                    $(".sortable").sortable();
                    $(".sortable").disableSelection();
                });
                container.appendChild(template);
            } else {
                console.error('Your browser does not support templates');
            }
        }

        function printProduct(sliderNameData, obj, sliderName) {
            var container = document.querySelector('.product-list-' + sliderNameData);
            var productCounter = Number(container.dataset.productCount);
            $.get('/back-ajax/?action=findBySku&sku=' + $(obj).parent().find('input').val(), function (JSON) {
                if ('content' in document.createElement('template')) {
                    var template = document.querySelector('#image-template').content.cloneNode(true);
                    template.querySelector('.product-title').innerText = JSON.title;
                    template.querySelector('.image-preview').src = JSON.imageSrc;
                    template.querySelector('.product-id-input').name = 'gf_category_product_slider_options[sliders][' + sliderName + '][products][' + productCounter + '][id]';
                    template.querySelector('.product-id-input').value = JSON.id;
                    productCounter++;

                    container.dataset.productCount = String(productCounter);
                    container.appendChild(template);

                } else {
                    console.error('Your browser does not support templates');
                }
            }, 'JSON');
        }

        $(document).on('click', '.remove-image', function (e) {
            e.preventDefault();
            $(this).parent().parent().find('input').val('');
            $(this).parent().parent().hide();
        });
        $(document).on('click', '.delete-slider', function (e) {
            e.preventDefault();
            var parent = $(this).parent().parent().parent();
            parent.find('select').each(function () {
                $(this).remove();
            });
            parent.find('input').each(function () {
                $(this).val("");
                $(this).remove();
            });
            parent.find('option').each(function () {
                $(this).val("");
            });
            parent.hide();
        });

        $(document).on('change', '.categorySelect', function () {
            let catLink = $(this).children("option:selected").data('cat-slug');
            $(this).parent().parent().find('.linkInput').val(catLink);
        });

        $(document).on('click', '.addProduct', function (e) {
            e.preventDefault();
            let sliderNameData = $(this).parent().parent().parent().data('sliderName');
            let sliderName = $(this).parent().parent().parent().find('.slider-heading').text().replace('Slider title: ','');
            let obj = $(this);
            printProduct(sliderNameData, obj, sliderName);
        })
    }
});
