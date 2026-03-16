$(document).ready(function(){

    if($("#reservasiTable").length){

        $("#reservasiTable").DataTable({

            ajax:{
                url:"/api/reservasi",
                dataSrc:"data"
            },

            columns:[
                {data:"id"},
                {data:"nama"},
                {data:"kamar"},
                {data:"checkin"},
                {data:"checkout"},
                {
                    data:"status",
                    render:function(data){

                        if(data=="Terisi"){
                            return '<span class="badge bg-danger">Terisi</span>'
                        }else{
                            return '<span class="badge bg-success">Tersedia</span>'
                        }

                    }
                },
                {
                    data:"id",
                    render:function(data){
                        return `<button class="btn btn-danger btn-sm delete" data-id="${data}">Delete</button>`
                    }
                }
            ]

        })

    }

})

$(document).on("click",".delete",function(){

    let id=$(this).data("id")

    if(confirm("hapus data?")){

        $.ajax({
            url:"/api/reservasi/"+id,
            type:"DELETE",
            success:function(){
                location.reload()
            }
        })

    }

})