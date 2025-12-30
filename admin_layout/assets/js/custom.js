$(document).ready(function () {

    // ✅ Define and expose the function globally
    window.initImageDropzone = function (dropzoneId, inputId, previewId, placeholderId) {
        const dropzone = $(dropzoneId);
        const fileInput = $(inputId);
        const previewImage = $(previewId);
        const placeholder = $(placeholderId);

        function handleFilePreview(file) {
            if (!file) return;

            const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                toastr.error('Only JPG, PNG, or WEBP images are allowed');
                fileInput.val('');
                previewImage.hide();
                placeholder.show();
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.attr('src', e.target.result).show();
                placeholder.hide();
            };
            reader.readAsDataURL(file);
        }

        // Unbind previous and bind fresh
        dropzone.off('click').on('click', function () {
            fileInput.trigger('click');
        });

        fileInput.off('change').on('change', function () {
            const file = this.files[0];
            handleFilePreview(file);
        });

        dropzone.off('dragover').on('dragover', function (e) {
            e.preventDefault();
            dropzone.css('background-color', '#eef');
        });

        dropzone.off('dragleave drop').on('dragleave drop', function () {
            dropzone.css('background-color', '#f9f9f9');
        });

        dropzone.off('drop').on('drop', function (e) {
            e.preventDefault();
            const files = e.originalEvent.dataTransfer.files;
            if (files.length) {
                fileInput[0].files = files;
                handleFilePreview(files[0]);
            }
        });

        // Optional reset if needed elsewhere
        window.resetDropzonePreview = function () {
            previewImage.hide().attr('src', '');
            fileInput.val('');
            placeholder.show();
        };
    };

    // ✅ Call it for create page
    initImageDropzone('#customDropzone', '#featured_image', '#previewImage', '#dropzonePlaceholder');
});
