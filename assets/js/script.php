// This message should appear in the console whenever script.js is loaded
console.log("script.js loaded – version with preset filters!");

// Run after the DOM has loaded
jQuery(document).ready(function ($) {
    console.log("Number of #preset-filters elements after DOM ready:", $('#preset-filters').length);

    var photoFilters = {
        brightness: 100,
        contrast: 100,
        saturate: 100,
        grayscale: 0,
        sepia: 0,
        invert: 0,
        borderRadius: 0,
        borderWidth: 0,
        borderStyle: 'solid',
        borderColor: '#000000'
    };

    // Preset filter configurations
    var presetConfigs = {
        none: { brightness: 100, contrast: 100, saturate: 100, grayscale: 0, sepia: 0 },
        sepia: { brightness: 110, contrast: 110, saturate: 90, grayscale: 0, sepia: 60 },
        grayscale: { brightness: 100, contrast: 100, saturate: 0, grayscale: 100, sepia: 0 },
        highContrast: { brightness: 110, contrast: 130, saturate: 110, grayscale: 0, sepia: 0 },
        highBrightness: { brightness: 130, contrast: 90, saturate: 100, grayscale: 0, sepia: 0 },
        vintage: { brightness: 120, contrast: 90, saturate: 85, grayscale: 0, sepia: 30 },
        cool: { brightness: 100, contrast: 100, saturate: 70, grayscale: 0, sepia: 0 },
        warm: { brightness: 102, contrast: 105, saturate: 120, grayscale: 0, sepia: 15 },
        duotone: { brightness: 100, contrast: 150, saturate: 0, grayscale: 100, sepia: 30 },
        dramatic: { brightness: 110, contrast: 150, saturate: 90, grayscale: 0, sepia: 0 }
    };

    function updatePhotoStyles() {
        var filterString =
            'brightness(' + photoFilters.brightness + '%) ' +
            'contrast(' + photoFilters.contrast + '%) ' +
            'saturate(' + photoFilters.saturate + '%) ' +
            'grayscale(' + photoFilters.grayscale + '%) ' +
            'sepia(' + (photoFilters.sepia || 0) + '%)';
        var borderString = photoFilters.borderWidth + 'px ' + photoFilters.borderStyle + ' ' + photoFilters.borderColor;
        $('.profile-photo-preview img').css({
            'filter': filterString,
            '-webkit-filter': filterString,
            'border-radius': photoFilters.borderRadius + 'px',
            'border': borderString
        });
        for (var filter in photoFilters) {
            var input = $('.photo-filter [data-filter="' + filter + '"]');
            if (input.length) {
                input.val(photoFilters[filter]);
            }
        }
        $('input[name="photo_filters"]').val(JSON.stringify(photoFilters));
    }

    $('#preset-filters').on('change', function () {
        var preset = $(this).val();
        console.log("Selected preset:", preset);
        if (preset in presetConfigs) {
            console.log("Applying preset:", presetConfigs[preset]);
            var borderSettings = {
                borderRadius: photoFilters.borderRadius,
                borderWidth: photoFilters.borderWidth,
                borderStyle: photoFilters.borderStyle,
                borderColor: photoFilters.borderColor
            };
            photoFilters = { ...presetConfigs[preset], ...borderSettings };
            console.log("Updated filters:", photoFilters);
            updatePhotoStyles();
        }
    });

    $('.photo-filter input[type="range"]').on('input', function () {
        var filter = $(this).data('filter');
        photoFilters[filter] = parseInt($(this).val(), 10);
        updatePhotoStyles();
        $('#preset-filters').val('none');
    });

    $('.photo-filter select, .photo-filter input[type="color"]').on('change input', function () {
        var filter = $(this).data('filter');
        photoFilters[filter] = $(this).val();
        updatePhotoStyles();
    });

    var mediaUploader;
    $('#upload_profile_photo_button').on('click', function (e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media({
            title: userProfilePhoto.title,
            button: { text: userProfilePhoto.button },
            multiple: false,
            library: { type: 'image' }
        });
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#user_profile_photo').val(attachment.url);
            $('.profile-photo-preview').html('<img src="' + attachment.url + '" />');
            $('#upload_profile_photo_button').hide();
            $('#remove_profile_photo_button').show();
            updatePhotoStyles();
        });
        mediaUploader.open();
    });

    $('#remove_profile_photo_button').on('click', function (e) {
        e.preventDefault();
        $('#user_profile_photo').val('');
        $('.profile-photo-preview').empty();
        $(this).hide();
        $('#upload_profile_photo_button').show();
    });

    if ($('#user_profile_photo').val()) {
        $('.profile-photo-preview').html('<img src="' + $('#user_profile_photo').val() + '" />');
        var savedFilters = $('input[name="photo_filters"]').val();
        if (savedFilters) {
            try {
                var parsedFilters = JSON.parse(savedFilters);
                photoFilters = { ...photoFilters, ...parsedFilters };
                updatePhotoStyles();
            } catch (e) {
                console.error('Error parsing saved filters:', e);
            }
        }
    }

    $('#upload_profile_photo_button').val(userProfilePhoto.upload);
    $('#remove_profile_photo_button').val(userProfilePhoto.remove);
});
