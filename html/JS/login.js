$(function () {
    var container = $(".numpad");
    var inputCount = 4;

    //Check indexDB for Client key
    //if (the client key exists) then 
    //  show login section
    //else
    // generate a new key 
    // Set the inputs with key
    // show the register section


    // Generate the input boxes
    // Generates the input container
    container.append("<div class='inputBoxes p-2'></div>");
    var inputBoxes = $(".inputBoxes");

    // Generates the boxes
    for (var i = 1; i < inputCount + 1; i++) {
        inputBoxes.append("<input type='password' maxlength=1 id='" + i + "' name='pin" + i + "' />");
    }

    container.append("<div class='numbers'></div>")
    var numbers = $(".numbers");
    // Generate the numbers
    for (var i = 1; i <= 9; i++) {
        numbers.append("<button class='number' type='button' name='" + i +
            "' onclick='addNumber(this)'><span class='pin_font'>" + i + "</span></button>");
    }

    // Generate last row

    // Delete button
    numbers.append(
        '<button class="number" type="button" name="del" onclick="deleteAll()"><span class="pin_font"><i class="fa fa-times" aria-hidden="true"></i></span></button>'
    );
    // Zero
    numbers.append(
        '<button class="number" type="button" name="0" onclick="addNumber(this)"><span class="pin_font">0</span></button>'
    )
    // Backspace
    numbers.append(
        '<button class="number" type="button" name="clear" onclick="removeNumber(this)"><span class="pin_font"><i class="fa fa-angle-double-left" aria-hidden="true"></i></span></button>'
    );
});

moveOnMax = function (field, nextFieldID) {
    if (field.value != '') {
        document.getElementById(nextFieldID).focus();
    }
}

addNumber = function (field) {
    if (!$("#1").val()) {
        $("#1").val(field.name).addClass("dot");
    } else if (!$("#2").val()) {
        $("#2").val(field.name).addClass("dot");
    } else if (!$("#3").val()) {
        $("#3").val(field.name).addClass("dot");
    } else if (!$("#4").val()) {
        $("#4").val(field.name).addClass("dot");
        $pin = $("#1").val() + $("#2").val() + $("#3").val() + $("#4").val();
        login($pin);
    };
}

deleteAll = function () {
    $("#1").val('').removeClass("dot");
    $("#2").val('').removeClass("dot");
    $("#3").val('').removeClass("dot");
    $("#4").val('').removeClass("dot");
}

removeNumber = function () {
    if ($('#4').val()) {
        $("#4").val('').removeClass("dot");
    } else if ($('#3').val()) {
        $("#3").val('').removeClass("dot");
    } else if ($('#2').val()) {
        $("#2").val('').removeClass("dot");
    } else if ($('#1').val()) {
        $("#1").val('').removeClass("dot");
    }
}

$(document).keyup(function (e) {
    if (e.keyCode == 8) {
        removeNumber();
    }
});

function login(pin) {
    //open db
    let users = JSON.parse(localStorage.getItem("user"));

    let userPin = users.filter(function (user) {
        return user.pwd == pin;
    })

    users.forEach(user => {
        if (user['pwd'] === pin) {
            sessionStorage.setItem("uid", user['id']);
            sessionStorage.setItem("acl", user['accesslevel']);
            sessionStorage.setItem("farm_id", user['id']);
        }

        if (sessionStorage.getItem("acl")) {
            //default guest
            let myPage = 'home.html';

            // // if admin
            // if (sessionStorage.getItem("acl") == 7) {
            //     myPage = 'admin_Summary.php';
            // }

            // // if user admin
            // if (sessionStorage.getItem("acl") == 4) {
            //     $myPage = 'user_InputSelect.html';
            // }

            // // if user
            // if (sessionStorage.getItem("acl") == 1) {
            //     myPage = 'home.html';
            // }

            //send logged in user to his page
            window.location.replace(myPage)
        } else {
            //user not in db
            window.location.replace("index.html");
            return;
        }
    });
}

function register(uuid, naam){
    if (window.navigator.onLine) {

        // set api stuff
        let baseURL = 'https://laptop.dev:8443';
        let apiKey = 'MucJIL1vkG6YJibwB7HINgvnT89gpK';
        let url = baseURL + '/API/client.php' + '?KEY=' + apiKey
        postData += ('&uid[]=' + uuid);
        postData += ('&naam[]=' + naam);
        postData += ('&kdatum[]=' + Date.now().toJSON());

        // send register request
        var xhttpCalls = new XMLHttpRequest();
        xhttpCalls.onreadystatechange = function () {
            window.location.replace("index.html");
            return;
        }

        xhttpCalls.open("POST", url, true);
        xhttpCalls.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttpCalls.timeout = 60000;
        changes = true;
        xhttpCalls.send(postData);
    }
}
