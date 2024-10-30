//Test
document.addEventListener('DOMContentLoaded', function (e) {
    const passwordInput = document.querySelector("#lieu_password");
    const passwordToggler = document.querySelector(".toggle-password");
    const loginInputs = Array.from(document.querySelectorAll(".login-input"));

    loginInputs.forEach((input) => {
        input.addEventListener("keyup", function (e) {
            const inputContainer = this.closest(".login-input-container");
            if (inputContainer.classList.contains("login-invalid-field")) {
                inputContainer.classList.remove("login-invalid-field");
            }
            if (this.value) {
                this.classList.add("not-empty");
            } else {
                this.classList.remove("not-empty");
            }
        });
    });

    passwordToggler.addEventListener("click", function (e) {
        e.preventDefault();
        passwordToggler.classList.toggle("toggled");
        if (passwordToggler.classList.contains("toggled")) {
            passwordInput.setAttribute("type", "text");
        } else {
            passwordInput.setAttribute("type", "password");
        }
    });


})

function getAuthorization() {
    var username=document.getElementById('lieu_email').value;
    var password=document.getElementById('lieu_password').value;

    if(!username||!password)
    {
        console.log("credential error");
        return;
    }


    const endPoint = "https://api.lieu.city/v1/login/wordpress/authorizations";
    return fetch(endPoint, {
        headers : {
            "Authorization" : "Basic " + btoa(username + ":" + password),
        },
        method : "POST"
    }).then((res) => res.json()).then((res) => {
        return res;
    }).catch((err) =>{
         console.error("Failed to get Authorization");
        
    });
}


