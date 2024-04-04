@extends('layouts.app')

@section ('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/forms/switches.css') }}">
<link href="{{ asset('admin-assets/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="stylesheet" href="{{ asset('admin-assets/plugins/richtexteditor/rte_theme_default.css') }}" />
<link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Banner</div>

                    <div class="panel-body">
                        <form method="POST" action="{{ route('banners.update', ['id' => $banner->id]) }}" enctype="multipart/form-data">
                            @method('POST')
                            @CSRF

                            <input type="hidden" name="id" value="{{ @$banner->id }}">


                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ @$banner->title }}" required>
                            </div>


                            <div class="form-group">
                                <label for="link">Link:</label>
                                <input type="text" class="form-control" id="link" name="link"
                                       value="{{ @$banner->link }}" required>
                            </div>

                            <!-- <div class="form-group">
                                <label for="image">Image:</label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                            </div> -->

                            <div class="col-md-12">
                                    <div class="custom-file-container" data-upload-id="mySecondImage">
                                        <label>Upload
                                            <a href="javascript:void(0)" class="custom-file-container__image-clear"
                                                title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file">
                                            <input name="file[]" type="file"
                                                class="custom-file-container__custom-file__custom-file-input" multiple>
                                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                            <span
                                                class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                    @if (isset($banner))
                                        <!-- <div class="image-list">
                                            <div class="form-media-box media-{{ $banner->id }}">
                                                <img src="{{ asset('uploads/content/' . $banner->image) }}" width="500"/>
                                            </div>
                                        </div> -->
                                    @endif
                                </div>


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                            <div class="col-md-12 mt-3" style="display: none;">
                                    <div class="form-group">
                                        <label for="summernote" class=""> Description</label>

                                        <div class="bg-white p-2 rounded-sm" id="">
                                            <textarea  id="mytextareaa"  name="description"
                                                rows="4">asd</textarea>
                                        </div>
                                    </div>
                                </div>

                            @if (count($errors))
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('admin-assets/plugins/richtexteditor/rte.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin-assets/plugins/richtexteditor/plugins/all_plugins.js') }}">
</script>
<script src="{{ asset('admin-assets/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
<script>
    jQuery(document).on('change', '.is_faq', function () {
        let value = $(this).is(':checked');
        if (value) {
            jQuery(".faq-sec").show(500)
        } else {
            jQuery(".faq-sec").hide(500)

        }
    })
    jQuery(document).on('click', '.new-faq', function () {
        let html = `
            <div class="faq-main">
                 <div class="faq-question">
                     <input placeholder="list item" class="form-control" name="question[]" type="text">
                     <button type='button' class="btn btn-danger btn-sm px-2  py-1 remove-faq" > <i class="fas fa-trash  pt-1 fa fa-solid fa-2x"></i> </button>
                 </div>
                 <div class="faq-answer">
                     <textarea placeholder="list description" class="form-control" name="answer[]"></textarea>
                 </div>
             </div>
            `;
        jQuery('.faq-sec').prepend(html)
    })
    jQuery(document).on('click', '.remove-faq', function () {
        jQuery(this).parent().parent().hide(500);
        setTimeout(() => {
            jQuery(this).parent().parent().remove();
        }, 600);
    })
    $(document).on('change', '#language', function () {

        if ($(this).val() == 'urdu') {

            $('#addform').attr('dir', 'rtl')
        } else {

            $('#addform').attr('dir', 'ltr')
        }
    })

    $(document).on('click', '.remove-file', function () {
        let id = $(this).attr('data-id');
        $('.remove-media-list').append(
            `<input type="hidden" name="removeMedia[]" value='${id}' id="removed-file-${id}">`);
        $(`.media-${id}`).addClass('removed-mediaa');
    })
    $(document).on('click', '.restore-media', function () {
        let id = $(this).attr('data-id');
        $(`#removed-file-${id}`).remove();
        $(`.media-${id}`).removeClass('removed-mediaa');
    })


    jQuery(document).on('change', '#image', function (e) {
        let file = e.target.files[0];
        jQuery('#output').attr('src', URL.createObjectURL(file));
    })

    var editor1 = new RichTextEditor("#mytextareaa");
    var secondUpload = new FileUploadWithPreview('mySecondImage')
    jQuery(".tagging").select2({
        tags: true
    });

</script>
@endsection
