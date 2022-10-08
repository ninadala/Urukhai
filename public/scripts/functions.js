const togglePassword = () => {
    const passwordInput = document.querySelector("#user_password")
    passwordInput.type = passwordInput.type === "text" ? "password" : "text"
    const eyeIcon = document.querySelector("#eye")
    eyeIcon.classList.contains("d-none") ? eyeIcon.classList.remove("d-none") : eyeIcon.classList.add("d-none")
    const eyeSlashIcon = document.querySelector('#eye-slash')
    eyeSlashIcon.classList.contains("d-none") ? eyeSlashIcon.classList.remove("d-none") : eyeSlashIcon.classList.add("d-none")
}

// const managePermission = () => {
//     const button = document.getElementById('flexSwitchCheckChecked')
//     if(button. )
// }

const filterShowActive = () => {
    const listItems = document.querySelectorAll(".list-group-item")
    listItems.forEach((item) => {
        item.classList.contains("list-group-item-dark") ? item.classList.add("d-none") : item.classList.remove("d-none")
    })
}

const filterShowInactive = () => {
    const listItems = document.querySelectorAll(".list-group-item")
    listItems.forEach((item) => {
        item.classList.contains("list-group-item-light") ? item.classList.add("d-none") : item.classList.remove("d-none")
    })
}

const filter = () => {
    const listItems = document.querySelectorAll(".list-group-item")
    listItems.forEach((item) => {
        item.classList.contains("list-group-item") ? item.classList.remove("d-none") : item.classList.remove("d-none")
    })
}