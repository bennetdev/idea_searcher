var search = "?" + location.search.substring(1);

async function get_random_word() {
    const result = await $.post("src/partials/getRandomWord.php" + search);
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
    $("#content").append("<input type='text' placeholder='input' class='input-word' style='position: absolute; left: " + left + "; top: " + top + "' value='" + word + "'>");
    $("#content input:last-child").focus();
    $("#content").scrollLeft(0);
}

$(document).ready(function () {
    get_random_word().then((response) => $("#word").html(response));
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
        var word = $("#word").text().trim();
        var words = $(".input-word");
        var json = {word: word, words: []}
        for (var i = 0; i < words.length; i++){
            var value = $(words[i]).val();
            var left = $(words[i]).position().left;
            var top = $(words[i]).position().top;
            json.words.push({word: value, left: left, top: top})
        }
        download(word + ".json", JSON.stringify(json))
    })
    $("#file").change(function () {
        get_json_by_file($("#file").prop("files")[0]).then((response) => json_to_page(response));
    })
    $("body").on("change", ".input-word", function () {
        $(this).attr("size", $(this).val().length)
    })
})