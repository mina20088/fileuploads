

$.when($.ready).then(function ()
{
    function filesShow()
    {
        $.ajax({
            url : "process/Showdata.php",
            method : "GET",
            contentType : "json",
            processData : false,
            success: function(data)
            {
                let UploadData = data.data
                let html = ""
                for(let data of UploadData)
                {
                    let{id,fileName,fileType,fileSize} = data
                    html +=
                        ` 
                       <tr>
                           <td>${id}</td>
                           <td>${fileName}</td>
                           <td>${fileType}</td>
                           <td>${fileSize}</td>
                           <td><a target="_blank" href="view.php?id=${id}">${fileName}</a></td>
                       </tr>
                    `

                }
                $('#tableContent').html(html)
            }
        })
    }
    filesShow();
    $("#upload").on('click',function (e){
        e.preventDefault();
        let fileData = $("#uploads").prop('files')[0]
        let formData = new FormData()
        formData.append('file',fileData)
        $.ajax({
            url : "process/upload-using-ajax.php",
            method : "POST",
            contentType : false,
            processData : false,
            data: formData,
            success: function ()
            {
               filesShow();
            }
        })
    })
})



