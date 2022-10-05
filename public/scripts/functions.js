const togglePassword = () => {
    const passwordInput = document.querySelector("#user_password")
    passwordInput.type = passwordInput.type === "text" ? "password" : "text"
    const eyeIcon = document.querySelector("#eye")
    eyeIcon.classList.contains("d-none") ? eyeIcon.classList.remove("d-none") : eyeIcon.classList.add("d-none")
    const eyeSlashIcon = document.querySelector('#eye-slash')
    eyeSlashIcon.classList.contains("d-none") ? eyeSlashIcon.classList.remove("d-none") : eyeSlashIcon.classList.add("d-none")
}

function filtre() { 
    console.log("test");
 }

// const franchiseFilter = () => {
//     console.log("test");
//     // const activatedField = document.querySelector("#listGroupItem")
//     // activatedField.type = activatedField.type === "text" ? "item" : "text"
//     // activatedField.classList.contains("disabled") ? activatedField.classList.add("d-none") : activatedField.classList.remove("d-none")
// }