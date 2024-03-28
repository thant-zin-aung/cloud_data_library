const timeoutSec = 2000;
const addFileButton = document.querySelector(".navigation-bar .add-file-icon-wrapper");
const homeTab = document.getElementsByClassName("home-tab")[0];
const postTab = document.getElementsByClassName("post-tab")[0];
const settingTab = document.getElementsByClassName("setting-tab")[0];
const aboutTab = document.getElementsByClassName("about-tab")[0];
const selectedTabColor = "selected-tab-color";
const phpProgress = document.getElementsByClassName("php-progress")[0];
const cloudProgress = document.getElementsByClassName("cloud-progress")[0];

function tabEventListener() {
    homeTab.addEventListener("click",event => {
        homeTab.classList.add(selectedTabColor);
        postTab.classList.remove(selectedTabColor);
        settingTab.classList.remove(selectedTabColor);
        aboutTab.classList.remove(selectedTabColor);
    });

    postTab.addEventListener("click",event => {
        homeTab.classList.remove(selectedTabColor);
        postTab.classList.add(selectedTabColor);
        settingTab.classList.remove(selectedTabColor);
        aboutTab.classList.remove(selectedTabColor);
    });

    settingTab.addEventListener("click",event => {
        homeTab.classList.remove(selectedTabColor);
        postTab.classList.remove(selectedTabColor);
        settingTab.classList.add(selectedTabColor);
        aboutTab.classList.remove(selectedTabColor);
    });

    aboutTab.addEventListener("click",event => {
        homeTab.classList.remove(selectedTabColor);
        postTab.classList.remove(selectedTabColor);
        settingTab.classList.remove(selectedTabColor);
        aboutTab.classList.add(selectedTabColor);
    });
}

tabEventListener();

homeTab.addEventListener("click",event=>{
    window.location.href="index.php";
})

addFileButton.addEventListener("click",e=>{
    window.location.href = "add-file.php";
});

aboutTab.addEventListener("click",event=> {
    window.location.href = "about-tab.php";
})