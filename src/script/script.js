
async function save() {
    const result = await $.post("src/partials/save.php", get_current_json());
    return result;
}

function get_current_json(){
    var word = $("#word").text().trim();
    var words = $(".input-word");
    var current_id = id == null ? "-1" : id;
    var json = {word: word, words: [], current_id: current_id}
    for (var i = 0; i < words.length; i++){
        var value = $(words[i]).val();
        var left = $(words[i]).position().left;
        var top = $(words[i]).position().top;
        var is_new = $(words[i]).data("new");
        json.words.push({word: value, left: left, top: top, new: is_new})
    }
    return json;
}

async function get_random_word() {
    const result = await $.post("src/partials/getRandomWord.php?" + search);
    return result;
}
async function get_json_by_file(file){
    var formdata = new FormData();
    formdata.append("file", file)
    const result = await fetch("src/partials/readJson.php", {
        method: "POST", body: formdata
    });
    return result.json();
}

function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}

function json_to_page(json){
    var upload = JSON.parse(json);
    var words = upload.words;
    $("#word").html(upload.word);
    for (var i = 0; i < words.length; i++){
        var word = words[i]
        append_input(word.left,word.top,word.word)
    }

}
function append_input(left, top, word){
    var top_calc = top - $("#content").position().top;
    $("#content").append("<input type='text' data-new=true placeholder='input' class='input-word' style='position: absolute; left: " + left + "; top: " + top_calc + "' value='" + word + "'>");
    $("#content input:last-child").focus();
    $("#content").scrollLeft(0);
}

$(document).ready(function () {
    var carousel = new Carousel("#save-left", "#save-right", "#saves");
    $("#content").on("click", "#next-word", function () {
        get_random_word().then((response) => $("#word").html(response));
    })
    $("#content").on("click", function (e) {
        if (!$(e.target).is("#content")) {
            return;
        }
        append_input(e.pageX, e.pageY, "");
    })
    $("#download").click(function () {
        download(word + ".json", JSON.stringify(get_current_json()))
    })
    $("#file").change(function () {
        get_json_by_file($("#file").prop("files")[0]).then((response) => json_to_page(response));
    })
    $("body").on("change", ".input-word", function () {
        $(this).attr("size", $(this).val().length)
    })
    $(".save").click(function () {
        if($(this).attr("id") === "add-save"){
            location.replace("http://localhost/idea/index.php?"+ search);
        }
        else{
            location.replace("http://localhost/idea/saves.php?id=" + $(this).attr("id") + "&" + search);
        }

    })
    $("#save").click(function () {
        save().then((response) => console.log(response));
    })
    $("#save-right").click(function () {
        carousel.next();
    })
    $("#save-left").click(function () {
        carousel.prev();
    })
    $("#hide-saves").click(function () {
        if($("#saves-box").css("display") === "none"){
            $("#saves-box").css("display", "flex");
            $(".save-move").css("display", "flex");
            $("#content").css("height", "calc(100% - 278px)");
            $("#hide-saves").html("keyboard_arrow_up");
        }
        else{
            $("#saves-box").css("display", "none");
            $(".save-move").css("display", "none");
            $("#content").css("height", "calc(100% - 58px)");
            $("#hide-saves").html("keyboard_arrow_down");
        }
    })
})