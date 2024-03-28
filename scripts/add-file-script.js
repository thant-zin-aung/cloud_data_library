new FinisherHeader({
    "count": 30,
    "size": {
      "min": 2,
      "max": 20,
      "pulse": 0
    },
    "speed": {
      "x": {
        "min": 0,
        "max": 0.8
      },
      "y": {
        "min": 0,
        "max": 0.2
      }
    },
    "colors": {
      "background": "#15182e",
      "particles": [
        "#ff926b",
        "#87ddfe",
        "#acaaff",
        "#1bffc2",
        "#f9a5fe"
      ]
    },
    "blending": "screen",
    "opacity": {
      "center": 1,
      "edge": 1
    },
    "skew": 0,
    "shapes": [
      "c",
      "s",
      "t"
    ]
  });

const needCheckbox = document.getElementsByClassName("need-checkbox")[0];
const mustCheckbox = document.getElementsByClassName("must-checkbox")[0];
const importantCheckbox = document.getElementsByClassName("important-checkbox")[0];
const fileInput = document.querySelector("#upload-info-wrapper .file-input");
const thumbnailInput = document.querySelector("#upload-info-wrapper .thumbnail-input");
const fileWrapper = document.querySelector("#upload-info-wrapper .file-wrapper");
const fileDetailText = document.querySelector("#upload-info-wrapper .file-upload-wrapper .detail-text");
const fileGalleryAnimationImage = document.querySelector("#upload-info-wrapper .file-upload-wrapper .gallary-image");
const thumbnailWrapper = document.querySelector("#upload-info-wrapper .thumbnail-wrapper");
const galleryAnimationImage = document.querySelector("#upload-info-wrapper .thumbnail-upload-wrapper .gallary-image");
const detailText = document.querySelector("#upload-info-wrapper .thumbnail-upload-wrapper .detail-text");
const detailSubText = document.querySelector("#upload-info-wrapper .thumbnail-upload-wrapper  .detail-sub-text");
const loadingWrapper = document.getElementsByClassName("loading-wrapper")[0];
const form = document.querySelector("#upload-info-wrapper form");


function checkboxListener() {
    needCheckbox.addEventListener("change",e=>{
        needCheckbox.checked=true;
        mustCheckbox.checked=false;
        importantCheckbox.checked=false;
    })
    mustCheckbox.addEventListener("change",e=>{
        mustCheckbox.checked=true;
        needCheckbox.checked=false;
        importantCheckbox.checked=false;
    })
    importantCheckbox.addEventListener("change",e=>{
        importantCheckbox.checked=true;
        needCheckbox.checked=false;
        mustCheckbox.checked=false;
    })
}
//https://w0.peakpx.com/wallpaper/155/132/HD-wallpaper-gradient-background-gradient-background-lockscreen.jpg

function convertByteToMB(byte) {
    var kb = byte/1024;
    var mb = kb/1024;
    return mb;
}

function fileThumbnailListener() {
    fileInput.addEventListener("change",event=> {
        var file = fileInput.files[0];
        if ( convertByteToMB(file.size) > 5  ) {
            fileInput.value = '';
            const backgroundValue = "background-image: none";
            fileWrapper.setAttribute("style",backgroundValue);
            fileWrapper.style.color = "black";
            fileGalleryAnimationImage.style.display = "block";
            fileDetailText.innerHTML = "Upload file here";
        } else {
            const backgroundValue = "background-image: url('https://w0.peakpx.com/wallpaper/155/132/HD-wallpaper-gradient-background-gradient-background-lockscreen.jpg')";
            fileWrapper.setAttribute("style",backgroundValue);
            fileWrapper.style.color = "white";
            fileGalleryAnimationImage.style.display = "none";
            fileDetailText.innerHTML = fileInput.files[0].name;
        }

    })
    thumbnailInput.addEventListener("change",event=> {
        let value = "background-image: url('"+URL.createObjectURL(event.target.files[0])+"')";
        thumbnailWrapper.setAttribute("style",value);

        galleryAnimationImage.classList.add("display-none");
        detailText.classList.add("display-none");
        detailSubText.classList.add("display-none");
    })
}

function submitButtonListener() {
    form.addEventListener("submit",event=>{
        loadingWrapper.style.display="flex";
        loadingWrapper.style.opacity=1;
    })
}

checkboxListener();
fileThumbnailListener();
submitButtonListener();

