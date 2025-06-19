( function( $ ) {

    $(document).ready(function (){
        form.init();
    });

    const form = {
        step: 1,
        steps: 4,
        answers: [],
        filepond: false,
        placeholders: {
            "charity": "Example: My name is Ashely, and I am an IVF success story. My son would not be here without the assistance of fertility treatments, and I’d like to pay it forward by assisting others struggling to conceive.\n" +
                "\n" +
                "Infertility is a painful condition that affects 1 in 8 couples in the US. To help, I'm raising money for the non-profit Gift of Parenthood. Gift of Parenthood’s mission is to provide a path towards parenthood by educating, inspiring, and providing fertility grants to couples and individuals struggling with infertility across the world.\n" +
                "\n" +
                "All funds go directly to Gift of Parenthood, and any donation helps further their cause. Thank you for your generosity!",
            "myself": "Example: My name is Ashley, and I have endometriosis, commonly referred to as endo for those who may not know. Endo is a common health condition in women where tissues grow outside of the uterus, causing pain and, often, infertility. Endo affects more than 11% of American women between 15 and 44. My partner and I have tried to get pregnant for the last decade; however, endo has made that journey a dead end. Luckily, we froze my eggs a few years ago to ensure we had a shot at surrogacy later on. Now, as we process the grief of endo ending my ability to carry a child, we look optimistically toward our future with gestational surrogacy. I have survived this debilitating medical condition because I am a fighter; however, my fight is not over. \n" +
                "\n" +
                "I am asking you to help us on this new path by donating to our fundraiser. We are seeking assistance with the financial burden of surrogacy, and we would be honored if you could help. Even $5 would mean the world to us and help me fight for our future family. Thank you for reading!",
            "family-friend": "Example: My sister Sarah always imagined that she’d have children. When she was a little girl, she had daydreams about finding the love of her life, getting married, and having dozens of cute bouncy babies. Naturally, as she got older, she became more realistic about her goals. She entered her late twenties with a solid career, 401k, and stock options, but something was missing: a family. Sarah had a few serious relationships, but none of her past partners were husband or father material. At 29, she decided to freeze her eggs at the suggestion of her physician. Now, gestational surrogacy costs, as she enters her early thirties, Sarah is tired of waiting for the “right” person to come into her life; she wants children, and time is ticking away. \n" +
                "\n" +
                "Sarah is a devoted nurse, a loving sister, daughter, and friend to many. I cannot think of anyone who deserves to be a parent more, and I want to help make her dream a reality. I am fundraising on her behalf, and all funds will go directly to her IVF journey. Please consider donating to help my sweet sister become a Mama!",
        },
        headings: {
            1: 'Let\'s Get Started!',
            2: 'Campaign Details',
            3: 'Add Photos And Video',
            4: 'Tell Your Story',
        },
        init() {
            this.initConditionalLogic();
            this.initNextButton();
            this.initPrevButton();
            this.initFilePond();
            this.initDatePickers();
            this.initAmount();
            this.initTitleField();
        },
        initConditionalLogic() {
            $('.new-fundraiser-form input[name="fundraising_for"]').on('change', (e) => {

                $('#fundraiser_description').attr('placeholder', this.placeholders[e.target.value]);

                if( e.target.value === 'family-friend' ) {
                    $('.new-fundraiser-form .question-wrap[data-parent="fundraising_for_family"]').show();
                } else {
                    $('.new-fundraiser-form .question-wrap[data-parent="fundraising_for_family"]').hide();
                }
            })
        },
        initNextButton() {
            $('.new-fundraiser-form .next').on('click', (e) => {
                e.preventDefault();

                if( this.step < this.steps ) {
                    this.next();
                } else {
                    this.submit();
                }
            })
        },
        initPrevButton() {
            $('.new-fundraiser-form .prev').on('click', (e) => {
                e.preventDefault();

                if( this.step === 2 ) {
                    $('.new-fundraiser-form .prev').hide();
                }

                this.prev();
            })
        },
        initFilePond() {
            // First register any plugins
            $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateSize);
            $.fn.filepond.registerPlugin(FilePondPluginFileValidateType);

            // Turn input element into a pond
            this.filepond = FilePond.create(
                document.querySelector('.filepond'), {
                    allowMultiple: true,
                    maxFiles: 5,
                    maxFileSize: '2MB',
                    maxParallelUploads: 5,
                    allowFileTypeValidation: true,
                    acceptedFileTypes: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'],
                    imagePreviewHeight: 220,
                    server: {
                        process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                            // fieldName is the name of the input field
                            // file is the actual file object to send
                            const formData = new FormData();
                            formData.append(fieldName, file, file.name);
                            formData.append('action', 'upload_new_fundraiser_image');

                            const request = new XMLHttpRequest();
                            request.open('POST', gop.ajax_url );

                            // Should call the progress method to update the progress to 100% before calling load
                            // Setting computable to false switches the loading indicator to infinite mode
                            request.upload.onprogress = (e) => {
                                progress(e.lengthComputable, e.loaded, e.total);
                            };

                            // Should call the load method when done and pass the returned server file id
                            // this server file id is then used later on when reverting or restoring a file
                            // so your server knows which file to return without exposing that info to the client
                            request.onload = function () {
                                if (request.status >= 200 && request.status < 300) {
                                    // the load method accepts either a string (id) or an object
                                    const response = JSON.parse(request.responseText);
                                    load(response.data.attach_id);
                                } else {
                                    // Can call the error method if something is wrong, should exit after
                                    error('oh no');
                                }
                            };

                            request.send(formData);

                            // Should expose an abort method so the request can be cancelled
                            return {
                                abort: () => {
                                    // This function is entered if the user has tapped the cancel button
                                    request.abort();

                                    // Let FilePond know the request has been cancelled
                                    abort();
                                },
                            };
                        },
                    },
                }
            );

            this.filepond.on('warning', (error, file) => {
                if( error.body === 'Max files' ) {
                    $('.file-error').text('You can upload up to 5 files. Maximum file size is 2MB per image.');
                }
            });

            const button = $('.new-fundraiser-form .actions .next');

            let aborted = 0;
            document.addEventListener('FilePond:error', (error, file) => {

                if( error.detail.error.main === 'File is too large' || error.detail.error.main === 'File is of invalid type' ) {
                    aborted++;
                    if( this.filepond.getFiles().length === aborted ) {
                       setTimeout(() => {
                           button.text('Next');
                           button.removeClass('disabled').removeAttr('disabled');
                       }, 100);
                    }
                }

                if( error.detail.error.main === 'File is of invalid type' ) {
                    $('.file-error').text('Image format is not compatible you can use JPEG, PNG, or GIF');
                }
            });

            this.filepond.on('addfilestart', (error, file) => {
                button.text('Uploading...');
                button.addClass('disabled').attr('disabled', 'disabled');
            });

            document.addEventListener('FilePond:processfilestart', (e) => {
                button.text('Processing...');
                button.addClass('disabled').attr('disabled', 'disabled');
            });

            let processed = 0;
            document.addEventListener('FilePond:processfile', (e) => {
                processed++;
                const total   = $('.filepond--item').length;
                const invalid = $('.filepond--item[data-filepond-item-state="load-invalid"]').length;

                if( total - invalid === processed ) {
                    button.text('Next');
                    button.removeClass('disabled').removeAttr('disabled');
                }
            });

            document.addEventListener('FilePond:processfiles', (e) => {
                button.text('Next');
                button.removeClass('disabled').removeAttr('disabled');
            });
        },
        initDatePickers() {
            $('.new-fundraiser-form .fundraiser-datepicker').flatpickr({
                dateFormat: "m/d/Y",
                disableMobile: "true",
                minDate: "today",
            });
        },
        initAmount() {

            const field = document.getElementById('amount');

            if( ! field ) {
                return false;
            }

            IMask(
                field,
                {
                    mask: '$num',
                    blocks: {
                        num: {
                            mask: Number,
                            thousandsSeparator: ','
                        }
                    }
                });
        },
        initTitleField(){
            const max_chars = 50;

            $('#fundraiser_name').on( 'keydown keyup', function(e){
                if ($(this).val().length >= max_chars) {
                    $(this).val($(this).val().substr(0, max_chars));
                }

                $(this).closest('.input-wrap').next().text((50 - $(this).val().length) + ' of 50 Character(s) left')
            });
        },

        next() {

            if( ! this.validateStep() ) {
                return false;
            }

            $('.new-fundraiser-form .step-wrap[data-step="' + this.step + '"]').hide();
            this.step++;
            $('.new-fundraiser-form .step-wrap[data-step="' + this.step + '"]').show();

            this.updateProgress();

            $('.new-fundraiser-form .prev').show();
        },
        prev() {
            $('.new-fundraiser-form .step-wrap[data-step="' + this.step + '"]').hide();
            this.step--;
            $('.new-fundraiser-form .step-wrap[data-step="' + this.step + '"]').show();

            this.updateProgress();
        },
        updateProgress() {
            let width = '1%';
            if( this.step !== 1 ) {
                width = 100 / this.steps * ( this.step - 1 ) + '%';
            }

            $('.new-fundraiser-form .steps .progress').css('width', width );
            $('.new-fundraiser-form .steps .current-step .step').text(this.step);

            $('.new-fundraiser-form .heading').text(this.headings[this.step]);
        },
        validateStep(){
            let valid = true;

            const questions = $('.new-fundraiser-form .step-wrap[data-step="' + this.step + '"] .question-wrap:visible');
            questions.each(function(){
                const field = $(this).find('input[required], select[required], textarea[required]');
                field.removeClass('error');
                $(this).find('.error-message').remove();

                // Validate YouTube video url.
                const video = $(this).find('#fundraiser_video');
                if( video.length > 0 ) {
                    video.removeClass('error');
                    const videoUrl = video.val();

                    if( videoUrl !== '' ) {
                        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
                        const match = videoUrl.match(regExp);

                        if ( ! match || match[2].length !== 11 ) {
                            video.addClass('error');
                            $(this).append('<div class="error-message">YouTube video link is not valid.</div>')
                            valid = false;
                        }
                    }
                }

                if( field.length === 0 ) {
                    return valid;
                }

                if(field.length === 1) {
                   if( field.attr('type') !== 'checkbox' && field.val() === '') {
                       field.addClass('error');
                       $(this).append('<div class="error-message">This is a required field.</div>')
                       valid = false;
                   }

                   if( field.attr('type') === 'checkbox' && ! field.is(':checked') ) {
                       field.addClass('error');
                       $(this).append('<div class="error-message">This is a required field.</div>')
                       valid = false;
                   }
                } else {
                   if( $(this).find('input:checked').length === 0 ) {
                       field.addClass('error');
                       $(this).append('<div class="error-message">This is a required field.</div>')
                       valid = false;
                   }
                }
            });

            return valid;
        },
        submit() {
            if( ! this.validateStep() ) {
                return false;
            }

            const form     = $('.new-fundraiser-form form');
            const formData = new FormData(form[0]);
            formData.append('action', 'save_new_fundraiser');

            $('.new-fundraiser-form .next')
                .text('Processing...')
                .addClass('disabled')
                .attr('disabled', 'disabled');

            $.ajax({
                type: 'post',
                url: gop.ajax_url,
                data : formData,
                contentType : false,
                processData : false,
            }).done(function(response) {
                const redirect_to = form.data('redirect');
                window.location.href = redirect_to;
            }).fail(function() {
                console.log('fail');
            });
        }
    }

} )( jQuery );
