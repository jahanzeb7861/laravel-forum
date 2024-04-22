@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/css/forms/switches.css') }}">
<link href="{{ asset('admin-assets/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="stylesheet" href="{{ asset('admin-assets/plugins/richtexteditor/rte_theme_default.css') }}" />
<link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
@endsection


<div style="display: flex; justify-content: space-between;; align-items:center;">

<h2>Users</h2>


<!-- <div class="mb-3">
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add New</a>
</div> -->



</div>


@if(count($users) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @if($user->type !== 'admin')
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="badge" style="padding: 5px 10px; border-radius: 4px; color: white;
                                            @if($user->status === 'Active')
                                                background-color: green;
                                            @else
                                                background-color: red;
                                            @endif">
                                    @if($user->status === 'Active')
                                        {{ $user->status }}
                                    @else
                                        In Active
                                    @endif
                                </div>
                            </td>

                            <td style="display: flex;">
                                <!-- Edit Icon -->
                                <a href="{{ route('users.edit', $user->id) }}" class="mr-2">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <!-- Delete Option -->
                                <!-- <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger" style="padding: 1px 12px 12px 15px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form> -->
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>There are no relevant results at this time.</p>
@endif

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

    // jQuery(document).on('submit', '#addform', function(e) {
    //     e.preventDefault();
    //     jQuery('.submit-btn').html(
    //         `<div class="spinner-border text-white mr-2 align-self-center loader-sm "></div> Loading...`
    //     );

    //     let action = jQuery(this).attr('action');
    //     let method = jQuery(this).attr('method');
    //     $.ajax({
    //         type: 'POST',
    //         url: action,
    //         data: new FormData(this),
    //         contentType: false,
    //         processData: false,
    //         dataType: "JSON",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(result) {
    //             $("#alert").html(alertMessage(result));
    //             $("html, body").animate({
    //                 scrollTop: 0,
    //             }, 1000);

    //             if (result['status'] == "success" && method.toLowerCase() === 'post') {
    //                 $("#addform").trigger("reset");
    //                 $('.custom-file-container__image-preview ').html();
    //                 $('#keywords').val(null).trigger('change')
    //                 $('#summernote').summernote('code', '');
    //             }

    //             // Additional logic for success can go here
    //         },
    //         error: function(error) {
    //             console.log(error);
    //             jQuery('.submit-btn').html(`Try Again!`);
    //         },
    //         complete: function() {
    //             // This will be executed whether the request is successful or not
    //             jQuery('.submit-btn').html(`Save Changes`);
    //         }
    //     });
    // });

    var editor1 = new RichTextEditor("#mytextareaa");
    var secondUpload = new FileUploadWithPreview('mySecondImage')
    jQuery(".tagging").select2({
        tags: true
    });

</script>
@endsection
