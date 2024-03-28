const profilePhotoFile = document.getElementById("profile-photo-file");
const profileCard = document.getElementsByClassName("profile-card")[0];
const profileDataWrapper = document.getElementsByClassName("profile-data-wrapper")[0];
const backButton = document.querySelector("nav .back-button");

profilePhotoFile.addEventListener("change",(event)=> {
    let value = "background-image: url('"+URL.createObjectURL(event.target.files[0])+"')";
    var urlLink = URL.createObjectURL(event.target.files[0]);
    console.log(urlLink);
    profileCard.setAttribute("style",value);
    profileDataWrapper.style.display = "none";
});

backButton.addEventListener("click",e=>{
    window.location.href = "../index.html";
})