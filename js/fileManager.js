/**
 * Created by AKASH GUPTA on 3/29/2016.
 */
$(document).ready(function() {

    var folderName;
    var dir_parent = "/";
    var fileName;
    var selectedItem;
    var cut_name;
    var cut_path;
    var currentID;

    var lfolderName;
    var lfileName;
    var lselectedItem;
    var lcurrentID;
    var ldir_parent;

    refreshPage();
    function refreshPage() {

        $('#path').html(dir_parent);
        $.ajax({
            type: "post",
            url: "http://cloudfog.co.nf/php/file_manager.php",
            data: {'dir_parent': dir_parent},
            cache: false,
            success: function (returnV1) {
                var display = $(returnV1).on('click', function () {
                    ///////////////////////////////////////////////////////////////////////////////////////
                    $('div').on("click", "#dir", function () {                 //Folder events
                        folderName = $(this).attr("name");                      //selectrd foldername
                        selectedItem = folderName;
                        currentID = $(this).attr("id");
                        $(this).css("background-color", "white");
                        $(this).siblings().css("background", "none");
                        $(this).on('dblclick', function () {
                            dir_parent = folderName;
                            $('#path').html(dir_parent);
                            refreshPage();
                        });
                    });
                    ///////////////////////////////////////////////////////////////////////////////////////
                    $('div').on("click", "#file", function () {                 //Ffile Click events
                        fileName = $(this).attr("name");                        //selectrd filename
                        selectedItem = fileName;
                        currentID = "file";
                        $(this).css("background-color", "white");
                        $(this).siblings().css("background", "none");
                        $(this).on('dblclick', function () {
                            //alert(fileName);
                            refreshPage();
                        });
                    });
                    /////////////////////////////////////////////////////////////////////////////////////////

                    /////////////////////////////////////////////////////////////////////////////////////////
                });
                $("#folders_row").html(display);

                //////////////////////////////////////////////////////////////////////////////////////////////
            }
        });

        $.ajax({
            type:"POST",
            url: "http://cloudfog.co.nf/php/file_manager.php",
            data:{'left_dir_parent':dir_parent},
            cache: false,
            success: function(returnDirForLeft){
                $('div').on("click", "#ldir", function () {
                    lfolderName = $(this).attr("name");
                    currentID = $(this).attr("id");
                    $(this).siblings().css("background", "none");
                    ldir_parent = folderName;
                    $.ajax({
                        type:"POST",
                        url: "http://cloudfog.co.nf/php/file_manager.php",
                        data: {'ldir_parent':ldir_parent},
                        cache: false,
                        success: function (returnlPane){
                            $("#lfolderName").text("hello");
                        }
                    });
                });
                $("#navigationPane").html(returnDirForLeft);
                $("#navigationPane").accordion();
            }
        });
    }

    $('#back').on("click", function () {              //back button
        $.ajax({
            type: "post",
            url: "http://cloudfog.co.nf/php/file_manager.php",
            data: {'dit_parent_back': dir_parent},
            cache: false,
            success: function (returnV2) {
                dir_parent = returnV2;
                $.ajax({
                    type: "post",
                    url: "http://cloudfog.co.nf/php/file_manager.php",
                    data: {'back_dir': dir_parent},
                    cache: false,
                    success: function (back_return) {
                        $("#folders_row").html(back_return);
                    }
                });
                refreshPage();
            }
        });
    });

    $("#home").on("click", function () {
        dir_parent = "/";
        refreshPage();
    });

    $("#dir").on('click', function () {
        alert("akash");
    });

    //calling
    $('#create').on("click", function () {
        $("#folderDetails").modal();
    });

    $("#addFolder").on('click', function () {
        var fName = $("#directory_name").val();
        $.ajax({
            type: "post",
            url: "http://cloudfog.co.nf/php/file_manager.php",
            data: {'fName': fName, 'dir_parent': dir_parent},
            cache: false,
            success: function (returnV) {
                $('#addFolderphp').html(returnV);
            }
        });
        refreshPage();
    });

    $("#remove").click(function () {
        $.ajax({
            type: "POST",
            url: "http://cloudfog.co.nf/php/file_manager.php",
            data: {'remove_dir': folderName, 'remove_dir_parent': dir_parent},
            cache: false,
            success: function (returnRemove) {
                //  alert(returnRemove);
                refreshPage();
            }
        });
    });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////// File Upload Contents ///////////////////////////////////////////////////////////////////////////////////////////

    $("#upload_file").on("click", function () {
        $("#upload_file_modal").modal();
    });

    $("#upload_file_data").on("click",function(){
        var file_name= $("#file_name").val();
        alert(file_name);
        $.ajax({
            type: "post",
            url: "http://cloudfog.co.nf/php/file_manager.php",
            data: {'file_name':file_name},
            cache: false,
            success: function (uploadedFile){
                alert(uploadedFile);
            }
        });
});

    ////////////////////////////// ENd of File upload contents ////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////// REMOVE FILE Click ////////////////////////////////////////////////////////////////////////////////////////////////


    $("#removeFile").on("click", function () {
        $.ajax({
            type: "post",
            url: "http://cloudfog.co.nf/php/file_manager.php",
            data: {'remove_file': fileName, 'remove_fileDir': dir_parent},
            cache: false,
            success: function (removeFileV) {
                //alert(removeFileV);
            }
        });
        refreshPage();
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////// MOVE Data /////////////////////////////////////////////////////////
    var clipboard;
    $("#cut").on("click",function(){
        if( currentID == "dir"){
            cut_name = selectedItem;
            cut_path = dir_parent;
            clipboard= "dir";
        }
        else if(currentID == "file"){
            cut_name = selectedItem;
            cut_path = dir_parent;
            clipboard = "file";
        }
    });

    $("#paste").on("click",function(){
        if(clipboard == 'dir')
            $.ajax({
                type: "POST",
                url: "http://cloudfog.co.nf/php/file_manager.php",
                data: {'cut_name':cut_name, 'cut_path':cut_path, 'paste_path':dir_parent},
                cache: false,
                success: function(pasteValue){
                   // alert (pasteValue);
                    currentID='';
                }

            });
        else if(clipboard == 'file'){
            $.ajax({
                type: "POST",
                url: "http://cloudfog.co.nf/php/file_manager.php",
                data: {'file_cut_name':cut_name, 'file_cut_path':cut_path, 'file_paste_path':dir_parent},
                cache: false,
                success: function(pasteValuefile){
                   // alert (pasteValuefile);
                    currentID='';
                }
            });
        }
        refreshPage();
    });

	$("#downloadf").on("click",function(){
		var download = fileName;
		var currentDir = dir_parent;
		$.ajax({
			type: "POST",
			url: "http://cloudfog.co.nf/php/file_manager.php",
			data: {'download':download, 'currentDir':currentDir},
			cache: false,
			success: function (pasteDownloaded){
				alert(pasteDownloaded);
			}
		});
	});

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////Left Pane////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



});
