jQuery(document).ready(function ($) {
    if (document.querySelector('#productSlider')) {
        var mediaUploader;
        var sliderName = null;
        $(".sortable").sortable();
        $(".sortable").disableSelection();
        $('#slider-add-button').click(function (e) {
            var sliderName = $('.slider-name-input').val().replace(/\s+/g, '-');
            printSliderForm(sliderName);
            $('.slider-name-input').val('');
        });

        function printAttachments(sliderName) {
            var attachments = mediaUploader.state().get('selection').toJSON();
            var container = document.querySelector(".images-list-" + sliderName);
            var imageCounter = Number(container.dataset.imageCount);

            for (var index in attachments) {
                if ('content' in document.createElement('template')) {
                    var template = document.querySelector('#image-template').content.cloneNode(true);
                    template.querySelector('.image-preview').src = attachments[index].url;
                    template.querySelector('.image-custom-link-input').name = 'gf_slider_options[sliders][' + sliderName + '][images][' + imageCounter + '][linkTo]';
                    template.querySelector('.image-url-input').name = 'gf_slider_options[sliders][' + sliderName + '][images][' + imageCounter + '][url]';
                    template.querySelector('.image-url-input').value = attachments[index].url;
                    imageCounter++;
                    container.dataset.imageCount = String(imageCounter);
                    container.appendChild(template);
                } else {
                    console.error('Your browser does not support templates');
                }
            }
        }

        function printSliderForm(sliderName) {
            if ('content' in document.createElement('template')) {
                var template = document.querySelector('#slider-form-template').content.cloneNode(true);
                template.querySelector('.images-list').dataset.imageCount = '0';
                template.querySelector('.images-list').className += '-' + sliderName;
                template.querySelector('.slider-heading').innerHTML += sliderName;
                template.querySelector('.slider-heading').dataset.sliderName = sliderName;
                template.querySelector('.images-width-input').name = 'gf_slider_options[sliders][' + sliderName + '][image_width]';
                template.querySelector('.images-height-input').name = 'gf_slider_options[sliders][' + sliderName + '][image_height]';
                template.querySelector('.images-slide-speed-input').name = 'gf_slider_options[sliders][' + sliderName + '][slide_speed]';
                var container = document.querySelector('#forms-container');
                container.appendChild(template);
            } else {
                console.error('Your browser does not support templates');
            }
        }

        $(document).on('click', '.upload-images', function (e) {
            e.preventDefault();
            sliderName = $(this).parent().find('.slider-heading').data('sliderName');
            mediaUploader = wp.media({
                multiple: 'add'
            });
            mediaUploader.on('select', function () {
                printAttachments(sliderName);
            });
            mediaUploader.open();
        });
        $(document).on('click', '.remove-image', function (e) {
            e.preventDefault();
            $(this).parent().next('.form-group').find('input').val('');
            $(this).parent().parent().hide();
        });
        $(document).on('click', '.delete-slider', function (e) {
            e.preventDefault();
            var parent = $(this).parent().parent().parent();
            parent.find('.slider-heading').data('sliderName');
            parent.find('input').each(function () {
                $(this).val("");
            });
            parent.hide();
        })
    }
});

