@extends('admin.layouts.app')
@section('page', 'Chat')

@section('content')
<section class="chat-content">
    <div class="container">
        <div class="row">
            <div class="col-12 px-0">
                <ul class="list-unstyled p-0 m-0">
                    @foreach($users as $key=> $user)
                        <li class="chat-list" onclick="fetchChatDetails({{$user->id}})">
                            <div class="img">
                                <img src="{{asset($user->image)}}"/>
                            </div>
                            <div class="info">
                                <h4>{{$user->name}}</h4>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
 	
<div class="chat-box" id="myForm">
    <div class="times-close">
        <iconify-icon icon="humbleicons:times"></iconify-icon>
    </div>

    <form method="post" action="{{route('admin.chat.store')}}" id="addToMessageForm" class="form-container">@csrf
        <h4>Chat</h4>

        <div id="messageContent" style="display: flex;flex-direction: column-reverse;">
            <ul class="list-unstyled p-0 m-0 px-4"></ul>
        </div>

        <div class="form-inputs">
            <div class='file'>
                <label for='input-file'><iconify-icon icon="heroicons:paper-clip-solid"></iconify-icon></label>
                <input id="input-file" name="file" type='file' />
            </div>
            <textarea placeholder="Type message.." name="message" id="msg"></textarea>
            <input type="hidden" name="userId" value="">
            <input type="hidden" name="channel_id" value="">
            <button type="submit" id="reviewBtn"><iconify-icon icon="wpf:paperplane"></iconify-icon></button>
        </div>
    </form>
</div>

@endsection

@section('script')
    <script src="https://code.iconify.design/iconify-icon/1.0.2/iconify-icon.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js" integrity="sha512-42PE0rd+wZ2hNXftlM78BSehIGzezNeQuzihiBCvUEB3CVxHvsShF86wBWwQORNxNINlBPuq7rG4WWhNiTVHFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const close = document.querySelector('.times-close')
        close.addEventListener('click', (e) => {
            chatBox.classList.remove('show-box')
        })
        const chatLists = document.querySelectorAll('.chat-list');
        const chatBox = document.querySelector('.chat-box');
        chatLists.forEach(chat => {
            chat.addEventListener('click', (e) => {
                chatBox.classList.add('show-box')
            })
        });

        function fetchChatDetails(userId) {
            $.ajax({
                url: '{{url("/")}}/admin/chat/view/'+userId,
                type: 'get',
                success:function(resp) {
                    $('input[name=userId]').val(userId);
                    let content = ``;

                    if (resp.status == 200) {
                        $.each(resp.data, (key, value) => {
                            // set left/ right side
                            let side = 'auth-user';
                            if(value.sender_id != 0) {
                                side = 'not-auth';
                            }

                            // set text/ document
                            if(value.flag == 'text') {
                                content += `
                                <li class="${side}"><div class="info"><h5>${value.message}</h5><span class="chat-date small">${moment(value.created_at).fromNow()}</span></div></li>
                                `;
                            } else {
                                if (
                                    value.file_extension == ".jpg" || 
                                    value.file_extension == ".jpeg" || 
                                    value.file_extension == ".png" || 
                                    value.file_extension == ".svg" ||
                                    value.file_extension == ".gif" ||
                                    value.file_extension == ".bmp"
                                ) {
                                    content += `
                                    <li class="${side}">
                                        <div class="info">
                                            <div class="info-top">
		                                    <img src="{{url('/')}}/${value.message}" style="height: 50px">
		                                    <a href="{{url('/')}}/${value.message}" download class="chat_download_btn" title="Download">
		                                        <iconify-icon icon="material-symbols:download"></iconify-icon>
		                                    </a>
                                            </div>
                                            <span class="chat-date small">${moment(value.created_at).fromNow()}</span>
                                        </div>
                                    </li>
                                    `;
                                } else {
                                    content += `
                                    <li class="${side}">
                                        <div class="info">
                                            <h5>DOCUMENT</h5>
                                            <a href="{{url('/')}}/${value.message}" download>
                                                <iconify-icon icon="material-symbols:download" class="chat_download_btn" title="Download"></iconify-icon>
                                            </a>
                                            <span class="chat-date small">${moment(value.created_at).fromNow()}</span>
                                        </div>
                                    </li>
                                    `;
                                }
                            }
                        });
                        $('input[name=channel_id]').val(resp.data[0].channel_id);
                    } else {
                        content += `
                        <li>No messages yet</li>
                        `;
                        $('input[name=channel_id]').val('new');
                    }

                    $('#messageContent ul').html(content);
                }
            })
        }

        // text message
        $(document).on('submit', '#addToMessageForm', (event) => {
            event.preventDefault();

            let message = $('#addToMessageForm textarea[name="message"]').val();
            let userId = $('input[name="userId"]').val();

            if (message.length > 0) {
                $.ajax({
                    url: "{{ route('admin.chat.store.ajax') }}",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        userId: userId,
                        channel_id: $('input[name="channel_id"]').val(),
                        message: message,
                    },
                    success: function(result) {
                        fetchChatDetails(userId);
                        $('#addToMessageForm textarea[name="message"]').val('');
                    }
                });
            }
        });

        // file message
        $(document).on('change', '#input-file', (event) => {
            event.preventDefault();

            let userId = $('input[name="userId"]').val();
            let channel_id = $('input[name="channel_id"]').val();

            var file_data = $('#input-file').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);

            $.ajax({
                url: "{{ url('/') }}/admin/chat/store/file/ajax/"+channel_id+"/"+userId,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(result) {
                    fetchChatDetails(userId);
                    $('#addToMessageForm textarea[name="message"]').val('');
                }
            });
        });
    </script>
@endsection
