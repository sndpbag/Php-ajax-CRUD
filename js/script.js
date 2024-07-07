$(document).ready(function(){

    $("#userForm").submit(function(e){
       e.preventDefault();

       var formData = new FormData(this);

        $.ajax({
            url : "insert.php",
            type : "POST",
            data : formData,
            contentType : false,
            processData : false,
            dataType : "json",
            success : function(data)
            {
                if(data.success) 
                {
                    // alert(data.msg);
                    // $("#success_msg").text(data.msg).css("color","green");
                    Swal.fire({
                        title: "Good JOb!",
                        text: data.msg,
                        icon: "success"
                      });

                    $("#userForm")[0].reset(); 

                    setTimeout(function(){
                        window.location.reload();
                    },2000)

                   
                    

                }
                else
                {
                    if(data.errors)
                    {
                     if(data.errors.name) {
                        $("#nameError").text(data.errors.name).css("color","red");

                        setTimeout(function(){
                            $("#nameError").fadeOut(function(){

                                $(this).text("");

                            })
                        },2000)

                     }  


                     if(data.errors.email) {
                        $("#emailError").text(data.errors.email).css("color","red");
                        setTimeout(function(){
                            $("#emailError").fadeOut(function(){

                                $(this).text("");

                            })
                        },2000)

                     }  


                    }


                }
            },
            error : function(xhr, status, error){
                console.error("Error: " + error);
            }

        })
        
    })

    // dispaly data

   var table = $("#userTable");

   $.ajax({
    url: "dispaly.php",
    type : "post",
    dataType : "json",
    success : function(data)
    {
        $.each(data,function(index,record){
            var row = "<tr>";
                 row+= "<td>"+(index+1)+"</td>";
                row+= "<td>"+record.name+"</td>";
                row+= "<td>"+record.email+"</td>";
                // row+= "<td>"+record.password+"</td>";
                row+= "<td> <img src='"+record.photo+"' width='50' height='50'></td>";
                row+= "<td> <a class='btn btn-primary edit_value' data-toggle='modal' data-target='#exampleModal' data-id='"+record.id +"'>Edit</a> </td>";
                row+= "<td> <a class='btn btn-primary delete_value' data-id='"+record.id +"'>Delete</a> </td>";
                
          
                 
                

                row+= "</tr>";
            table.append(row);

          
        })
    },
    error: function(xhr, status, error)
    {
        console.error("Error: " + error);
    }
   })

   // edit page

  $(document).on("click",".edit_value",function()
{
    var id = $(this).data("id");
   
    $.ajax({
        url : "edit.php",
        type : "post",
        data : {id:id},
        dataType : "json",
        success : function(data)
        {
            $("#userId").val(data[0].id);
            $("#Editname").val(data[0].name);
            $("#Editemail").val(data[0].email);
            $("#Editpassword").val(data[0].password);
            $("#Editphoto").val(data[0].photo);
        },
        error : function (xhr, status, error)
        {
            console.error("Error: " + error);
        }

    })

})

// update form
$("#editForm").submit(function(e){

    e.preventDefault();
    var formData = new FormData(this);
    var id = $("#userId").val();
    formData.append('id', id);

    $.ajax({
        url: "update.php",
        type: "post",
        data: formData,
        contentType : false,
        processData : false,
        dataType : "json",
        success: function(data)
        {
            Swal.fire({
                title: "Good JOb!",
                text: data.msg,
                icon: "success"
              });

              setTimeout(function(){
                window.location.reload();
              },2000)
        },
        error : function(xhr, status, error)
        {
            console.error("error:"+error);
        }




    })



});

/// delete record

 

$(document).on("click",".delete_value",function(e)
{
e.preventDefault();
    var id = $(this).data("id");
    var element = this;

    if(confirm("Are you sure you want to delete?"))
    {
     
    $.ajax({
        url : "delete.php",
        type : "POST",
        data : {id: id},
        dataType : "json",
        success : function(data)
        {
            Swal.fire({
                title: "Deleted!",
                text: data.msg,
                icon: "success"
              });

            $(element).closest("tr").fadeOut();
        },
        error : function(xhr, status, error)
        {
            console.error("Error: " + error);
        }

    })

}


});



});