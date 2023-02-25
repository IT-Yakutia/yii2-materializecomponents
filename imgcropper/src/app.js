var croppr = new Object();

function handleFileSelect(evt) {
    var file = evt.target.files; // FileList object
    current_crop_id = $(evt.target).data("cropp-wrapper-id");
    uic_id = $(evt.target).data("cropp-id");
    var f = file[0];
    // Only process image files.
    if (!f.type.match('image.*')) { 
        alert("Image only please....");
    }else{
        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                var img = document.getElementById(current_crop_id);
                img.innerHTML = [
                    '<p><img class="thumb" id="', uic_id, '" title="', escape(theFile.name), '" src="', e.target.result, '" /></p>'
                ].join('');
                croppr[uic_id] = new Croppr("#"+uic_id, eval("cropps_"+uic_id)["uic_settings"]);
            };
        })(f);
        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
    }
}

var inputs = document.getElementsByClassName(uic_file_input_class);
Array.prototype.forEach.call(inputs, function(element) {
    element.addEventListener('change', handleFileSelect, false);
});

function getImgCrop(id){
    var obj = croppr[id].getValue();
    var formData = new FormData();
    // Attach file
    formData.append('_csrf-backend', yii.getCsrfToken());
    formData.append('x', obj.x);
    formData.append('y', obj.y);
    formData.append('width', obj.width);
    formData.append('height', obj.height);
    formData.append('file', $('input[type="file"][name="file-'+id+'"]')[0].files[0]);

    showLoader(id);
    $.ajax({
        url: eval("cropps_"+id)["uic_url"],
        type: 'POST',
        data: formData,
        dataType: 'json',
        contentType: false,
        processData: false, 
    }).done(function (response) {
        if (response.error) {
            M.toast({html: response.error});
        }
        getImgUpdate(response.filelink, id);
        getThImgUpdate(response.th_filelink, id);
    }).fail(function(xhr, err) { 
        var responseTitle= $(xhr.responseText).filter('title').get(0);
        M.toast({html: $(responseTitle).text()});
    });
}
function getImgDelete(inputId, croppId){
    var modelPhotoInput = document.getElementById(inputId);
    modelPhotoInput.value = "";
    var modelThumbnail = document.getElementById(eval("cropps_"+croppId)["uic_modelThumbnail_id"]);
    modelThumbnail.src = eval("cropps_"+croppId)["uic_no_photo_src"];
}
function getImgUpdate(data, id){
    var modelPhotoInput = document.getElementById(eval("cropps_"+id)["uic_model_attribute_field_id"]);
    modelPhotoInput.value = data;
    var modelThumbnail = document.getElementById(eval("cropps_"+id)["uic_modelThumbnail_id"]);
    modelThumbnail.src = data;
    hideLoader(id);
}
function getThImgUpdate(data, id){
    var modelPhotoInput = document.getElementById(eval("cropps_"+id)["uic_model_th_attribute_field_id"]);
    modelPhotoInput.value = data;
}

function hideLoader(id){
    var loader = document.getElementById("preloader-" + id);
    name = "hide";
    arr = loader.className.split(" ");
    if (arr.indexOf(name) == -1) {
        loader.className += " " + name;
    }
}
function showLoader(id){
    var modelThumbnail = document.getElementById(eval("cropps_"+id)["uic_modelThumbnail_id"]);
    modelThumbnail.src = "";

    var loader = document.getElementById("preloader-" + id);
    loader.className = loader.className.replace(/\bhide\b/g, "");
}