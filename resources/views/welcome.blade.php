
    <!DOCTYPE html>
<html lang="en">
<head>
    <title>Chat GPT Laravel | Code with Ross</title>
    <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- End JavaScript -->

    <!-- CSS -->
    <link rel="stylesheet" href="/style.css">
    <!-- End CSS -->

</head>

<body>
<div class="chat">

    <!-- Header -->
    <div class="top">
        <img src="https://miro.medium.com/v2/resize:fit:1400/0*13i_twnrcso1mC1z" alt="Avatar">
        <div>
            <p>John Doe</p>
            <small>Online</small>
        </div>
    </div>
    <!-- End Header -->

    <!-- Chat -->
    <div class="messages">
        <div class="left message">
            <img src="https://avatars.githubusercontent.com/u/40673377?v=4" alt="Avatar">
            <p>Start chatting with Chat GPT AI below!!</p>
        </div>
    </div>
    <!-- End Chat -->

    <!-- Footer -->
    <div class="bottom">
        <form>
            <input type="text" id="message" name="message" placeholder="Enter message..." autocomplete="off">
            <button type="submit"></button>
        </form>
    </div>
    <!-- End Footer -->

</div>
</body>

<script>
    //Broadcast messages
    $("form").submit(function (event) {
        event.preventDefault();

        //Stop empty messages
        if ($("form #message").val().trim() === '') {
            return;
        }

        //Disable form
        $("form #message").prop('disabled', true);
        $("form button").prop('disabled', true);

        $.ajax({
            url: "/api/chat",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            data: {
                "model": "gpt-4o-mini",
                "content": $("form #message").val()
            }
        }).done(function (res) {

            //Populate sending message
            $(".messages > .message").last().after('<div class="right message">' +
                '<p>' + $("form #message").val() + '</p>' +
                '<img src="https://assets.edlin.app/images/rossedlin/03/rossedlin-03-100.jpg" alt="Avatar">' +
                '</div>');

            //Populate receiving message
            $(".messages > .message").last().after('<div class="left message">' +
                '<img src="https://avatars.githubusercontent.com/u/40673377?v=4" alt="Avatar">' +
                '<p>' + res + '</p>' +
                '</div>');

            //Cleanup
            $("form #message").val('');
            $(document).scrollTop($(document).height());

            //Enable form
            $("form #message").prop('disabled', false);
            $("form button").prop('disabled', false);
        });
    });

</script>
</html>
