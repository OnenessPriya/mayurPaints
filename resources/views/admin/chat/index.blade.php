@extends('admin.layouts.app')
@section('page', 'Chat')

@section('content')
<section class="chat-content">
    <div class="container">
        <div class="row">
            <div class="col-12 px-0">
                <ul class="list-unstyled p-0 m-0">
                    @foreach($users as $key=> $user)
                        <li class="chat-list" onclick="fetchChatDetails($user->id)">
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

    <form id="addToMessageForm" class="form-container">
        <h4>Chat</h4>

        <div id="messageContent">
            <ul class="list-unstyled p-0 m-0 px-4">
                <li class="auth-user"><div class="img"><img src="https://img.freepik.com/free-photo/indian-man-smiling-cheerful-expression-closeup-portrait_53876-129387.jpg?w=740&t=st=1678447891~exp=1678448491~hmac=a75cdfc94c29852ec6602252c44d7763b5681e53bb3b23e91c592439dcd510c2"/></div> <div class="info">Comment1 <span class="chat-date">22nd Jan, 2023. 8:30 am</span></div></li>
                <li class="auth-user"><div class="img"><img src="https://img.freepik.com/free-photo/indian-man-smiling-cheerful-expression-closeup-portrait_53876-129387.jpg?w=740&t=st=1678447891~exp=1678448491~hmac=a75cdfc94c29852ec6602252c44d7763b5681e53bb3b23e91c592439dcd510c2"/></div> <div class="info">Comment1 <span class="chat-date">22nd Jan, 2023. 8:30 am</span></div></li>
                <li class="auth-user"><div class="img"><img src="https://img.freepik.com/free-photo/indian-man-smiling-cheerful-expression-closeup-portrait_53876-129387.jpg?w=740&t=st=1678447891~exp=1678448491~hmac=a75cdfc94c29852ec6602252c44d7763b5681e53bb3b23e91c592439dcd510c2"/></div> <div class="info">Comment1 <span class="chat-date">22nd Jan, 2023. 8:30 am</span></div></li>
                <li class="auth-user"><div class="img"><img src="https://img.freepik.com/free-photo/indian-man-smiling-cheerful-expression-closeup-portrait_53876-129387.jpg?w=740&t=st=1678447891~exp=1678448491~hmac=a75cdfc94c29852ec6602252c44d7763b5681e53bb3b23e91c592439dcd510c2"/></div> <div class="info">Comment1 <span class="chat-date">22nd Jan, 2023. 8:30 am</span></div></li>
                <li class="not-auth"><div class="img"><img src="https://img.freepik.com/free-photo/indian-man-smiling-cheerful-expression-closeup-portrait_53876-129387.jpg?w=740&t=st=1678447891~exp=1678448491~hmac=a75cdfc94c29852ec6602252c44d7763b5681e53bb3b23e91c592439dcd510c2"/></div> <div class="info">Comment1 <span class="chat-date">22nd Jan, 2023. 8:30 am</span></div></li>
                <li class="not-auth"><div class="img"><img src="https://img.freepik.com/free-photo/indian-man-smiling-cheerful-expression-closeup-portrait_53876-129387.jpg?w=740&t=st=1678447891~exp=1678448491~hmac=a75cdfc94c29852ec6602252c44d7763b5681e53bb3b23e91c592439dcd510c2"/></div> <div class="info">Comment1 <span class="chat-date">22nd Jan, 2023. 8:30 am</span></div></li>
                <li class="auth-user"><div class="img"><img src="https://img.freepik.com/free-photo/indian-man-smiling-cheerful-expression-closeup-portrait_53876-129387.jpg?w=740&t=st=1678447891~exp=1678448491~hmac=a75cdfc94c29852ec6602252c44d7763b5681e53bb3b23e91c592439dcd510c2"/></div> <div class="info">Comment1 <span class="chat-date">22nd Jan, 2023. 8:30 am</span></div></li>
            </ul>
        </div>

        <div class="form-inputs">
            <div class='file'>
                <label for='input-file'>
                <iconify-icon icon="heroicons:paper-clip-solid"></iconify-icon>
                </label>
                <input id='input-file' type='file' />
            </div>
            <textarea placeholder="Type message.." name="msg" id="msg" required></textarea>
            <button type="submit" ><iconify-icon icon="wpf:paperplane"></iconify-icon></button>
        </div>
    </form>
</div>
@endsection

@section('script')
    <script src="https://code.iconify.design/iconify-icon/1.0.2/iconify-icon.min.js"></script>

    <script>
        const close = document.querySelector('.times-close')
        close.addEventListener('click', (e) => {
            chatBox.classList.remove('show-box')
        })
        const chatLists = document.querySelectorAll('.chat-list');
        const chatBox = document.querySelector('.chat-box');
        chatBox.classList.add('show-box');
        chatLists.forEach(chat => {
        chat.addEventListener('click', (e) => {
        chatBox.classList.add('show-box')
        })
        });

        function fetchChatDetails($userId) {
            $.ajax({
                url: '{{ route('admin.chat.viw') }}',
                type: 'post',
                data: {

                },
                success:function(resp) {

                }
            })
        }
    </script>
@endsection
