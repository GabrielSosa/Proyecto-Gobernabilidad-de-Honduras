
var manageMemberTable;

$(document).ready(function() {
	
	Departamentos();
	Validacion();

	manageMemberTable = $("#manageMemberTable").DataTable({
		"ajax": "Backend/agregaUsuarios.php",
		"order": []
	}); 

	$("#addMemberModalBtn").on('click', function() {
		// reset the form 
		$("#createMemberForm")[0].reset();
		// remove the error 
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$(".text-danger").remove();
		// empty the message div
		$(".messages").html("");

		// submit form
		$("#createMemberForm").unbind('submit').bind('submit', function() {

			$(".text-danger").remove();

			var form = $(this);

			// validation
			var nombreUsuario = $("#nombreUsuario").val();
			var nombreCompleto = $("#nombreCompleto").val();
			var contresenia = $("#contresenia").val();
			var repeatContrasenia = $("#repeatContrasenia").val();
			var privilegios = $("input:radio[name=privilegios]:checked").val();
			var depto = $( "select[name='areaDepto[]']" ).val();
			var muni = $( "select[name='areaMuni[]']" ).val();
			var varlorpass = true;

			console.log(contresenia);
			console.log(repeatContrasenia);
			if(nombreUsuario == "") {
				$("#nombreUsuario").closest('.form-group').addClass('has-error');
				$("#nombreUsuario").after('<p class="text-danger">El nombre de usuario es requerido</p>');
			} else {
				$("#nombreUsuario").closest('.form-group').removeClass('has-error');
				$("#nombreUsuario").closest('.form-group').addClass('has-success');				
			}

			if(nombreCompleto == "") {
				$("#nombreCompleto").closest('.form-group').addClass('has-error');
				$("#nombreCompleto").after('<p class="text-danger">El nombre completo es requerido</p>');
			} else {
				$("#nombreCompleto").closest('.form-group').removeClass('has-error');
				$("#nombreCompleto").closest('.form-group').addClass('has-success');				
			}

			if(contresenia == "") {
				$("#contresenia").closest('.form-group').addClass('has-error');
				$("#contresenia").after('<p class="text-danger">La contraseña es requerida</p>');
			} else {
				$("#contresenia").closest('.form-group').removeClass('has-error');
				$("#contresenia").closest('.form-group').addClass('has-success');				
			}

			if(repeatContrasenia == "") {
				$("#repeatContrasenia").closest('.form-group').addClass('has-error');
				$("#repeatContrasenia").after('<p class="text-danger">Repetir la contraseña es requerido</p>');
			} else {
				$("#repeatContrasenia").closest('.form-group').removeClass('has-error');
				$("#repeatContrasenia").closest('.form-group').addClass('has-success');				
			}

			if(repeatContrasenia === contresenia) {
				$("#repeatContrasenia").closest('.form-group').removeClass('has-error');
				$("#repeatContrasenia").closest('.form-group').addClass('has-success');	
				$("#contresenia").closest('.form-group').removeClass('has-error');
				$("#contresenia").closest('.form-group').addClass('has-success');
				varlorpass = true;			
			} else {
				$("#repeatContrasenia").closest('.form-group').addClass('has-error');
				$("#repeatContrasenia").after('<p class="text-danger">Las contraseñas no coinciden</p>');
				$("#contresenia").closest('.form-group').addClass('has-error');
				$("#contresenia").after('<p class="text-danger">Las contraseñas no coinciden</p>');
				varlorpass = false;	
			} 

			if(privilegios == undefined) {
				$("input:radio[name=privilegios]").closest('.form-group').addClass('has-error');
				//$(".radio").after('<div class="col-xs-6"><p class="text-danger">Los privilegios son requeridos</p></div>');
			} else {
				$("input:radio[name=privilegios]").closest('.form-group').removeClass('has-error');
				$("input:radio[name=privilegios]").closest('.form-group').addClass('has-success');				
			}

			if(depto == null) {
				$("select[name='areaDepto[]']").closest('.form-group').addClass('has-error');
				$("select[name='areaDepto[]']").after('<div><p class="text-danger">Ingrese un departamento</p></div>');
			} else {
				$("select[name='areaDepto[]']").closest('.form-group').removeClass('has-error');
				$("select[name='areaDepto[]']").closest('.form-group').addClass('has-success');				
			}

			if(muni == null) {
				$("select[name='areaMuni[]']").closest('.form-group').addClass('has-error');
				$("select[name='areaMuni[]']").after('<p class="text-danger">Ingrese un departamento</p>');
			} else {
				$("select[name='areaMuni[]']").closest('.form-group').removeClass('has-error');
				$("select[name='areaMuni[]']").closest('.form-group').addClass('has-success');				
			}

			
			if(nombreUsuario && nombreCompleto && contresenia && repeatContrasenia && depto && muni && privilegios && varlorpass) {
				//submit the form to server
				$.ajax({
					url : form.attr('action'),
					type : form.attr('method'),
					data : form.serialize(),
					dataType : 'json',
					success:function(response) {

						// remove the error 
						$(".form-group").removeClass('has-error').removeClass('has-success');

						if(response.success == true) {
							$(".messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="fa fa-check"></span> </strong>'+response.messages+
							'</div>');

							// reset the form
							$("#createMemberForm")[0].reset();		

							// reload the datatables
							manageMemberTable.ajax.reload(null, false);
							// this function is built in function of datatables;

						} else {
							$(".messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="fa fa-exclamation"></span> </strong>'+response.messages+
							'</div>');
						}  // /else
					} // success  
				}); // ajax subit 				
			} /// if
			
			return false;
		}); // /submit form for create member
	}); // /add modal
	

});

function Validacion() {

	$("#createMemberForm").validate({
	           rules: {
	               contresenia: { 
	                 required: true,
	                    minlength: 6,
	                    maxlength: 10,

	               } , 

	                   repeatContrasenia: { 
	                    equalTo: "#contresenia",
	                     minlength: 6,
	                     maxlength: 10
	               }


	           },
	     messages:{
	         contresenia: { 
	                 required:"Password Requerido",
	                 minlength: "Minimo 6 caracteres",
	                 maxlength: "Maximo 10 caracteres"
	               },
	       repeatContrasenia: { 
	         equalTo: "La contraseña debe ser igual al anterior",
	         minlength: "Minimo 6 caracteres",
	         maxlength: "Maximo 10 caracteres"
	       }
	     }

	});

}


function Departamentos() {
	


	  $.post( 'Buscadores/departamentoUsuario.php' ).done( function(respuesta)
	  {
	    $( "select[name='areaDepto[]']" ).html( respuesta );
	  });

}

$( "select[name='areaDepto[]']").change(function()
  {
  	var ArrayDepto = [];
	$("select[name='areaDepto[]'] :selected").each(function(i, selected){
	 
		ArrayDepto[i] = $(selected).val();

	});
	
	var data = JSON.stringify(ArrayDepto);
    // Lista de municipios
    $.post( 'Buscadores/municipioUsuario.php', { data: data} ).done( function( respuesta )
    {
      $( "select[name='areaMuni[]']" ).html( respuesta );
    });
    
  });


function removeMember(id = null) {

	if(id) {
	   // click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			//$("#editN").val('NOSE');
			$.ajax({
				url: 'Backend/removerUsuario.php',
				type: 'post',
				data: {member_id : id},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {						
						$(".removeMessages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="fa fa-pencil-square-o"></span> </strong>'+response.messages+
							'</div>');

						// refresh the table
						manageMemberTable.ajax.reload(null, false);

						// close the modal
						$("#removeMemberModal").modal('hide');

					} else {
						$(".removeMessages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="fa fa-trash-o"></span> </strong>'+response.messages+
							'</div>');
					}
				}
			});
		}); // click remove btn
	} else {
		alert('Error: Refresh the page again');
	}
}

function editMember(id = null) {
	
	if(id) {

		// remove the error 
		$(".form-group").removeClass('has-error').removeClass('has-success');
		$(".text-danger").remove();
		// empty the message div
		$(".edit-messages").html("");

		// remove the id
		$("#member_id").remove();

		// fetch the member data
		$.ajax({
			url: 'Backend/getSelectedUsuario.php',
			type: 'post',
			data: {member_id : id},
			dataType: 'json',
			success:function(response) {

				$("#editName").val(response.usuario);
				$("#editnombreCompleto").val(response.nombrecompleto);
				$("#editcontresenia").val(response.contresenia);
				$("#editrepeatContrasenia").val(response.contresenia);
				$("#"+response.privilegios+"").attr('checked', true);

			//	$("#editActive").val(response.active);	
				// mmeber id 
				$(".editMemberModal").append('<input type="hidden" name="member_id" id="member_id" value="'+response.usuario+'"/>');

				// here update the member data
				$("#updateMemberForm").unbind('submit').bind('submit', function() {
					// remove error messages
					$(".text-danger").remove();

					var form = $(this);

					// validation
					var editName = $("#editName").val();
					var editAddress = $("#editAddress").val();
					var editContact = $("#editContact").val();
					var editActive = $("#editActive").val();

					if(editName == "") {
						$("#editName").closest('.form-group').addClass('has-error');
						$("#editName").after('<p class="text-danger">The Name field is required</p>');
					} else {
						$("#editName").closest('.form-group').removeClass('has-error');
						$("#editName").closest('.form-group').addClass('has-success');				
					}

					if(editAddress == "") {
						$("#editAddress").closest('.form-group').addClass('has-error');
						$("#editAddress").after('<p class="text-danger">The Address field is required</p>');
					} else {
						$("#editAddress").closest('.form-group').removeClass('has-error');
						$("#editAddress").closest('.form-group').addClass('has-success');				
					}

					if(editContact == "") {
						$("#editContact").closest('.form-group').addClass('has-error');
						$("#editContact").after('<p class="text-danger">The Contact field is required</p>');
					} else {
						$("#editContact").closest('.form-group').removeClass('has-error');
						$("#editContact").closest('.form-group').addClass('has-success');				
					}

					if(editActive == "") {
						$("#editActive").closest('.form-group').addClass('has-error');
						$("#editActive").after('<p class="text-danger">The Active field is required</p>');
					} else {
						$("#editActive").closest('.form-group').removeClass('has-error');
						$("#editActive").closest('.form-group').addClass('has-success');				
					}

					if(editName && editAddress && editContact && editActive) {
						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),
							dataType: 'json',
							success:function(response) {
								if(response.success == true) {
									$(".edit-messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <span class="fa fa-check"></span> </strong>'+response.messages+
									'</div>');

									// reload the datatables
									manageMemberTable.ajax.reload(null, false);
									// this function is built in function of datatables;

									// remove the error 
									$(".form-group").removeClass('has-success').removeClass('has-error');
									$(".text-danger").remove();
								} else {
									$(".edit-messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <span class="fa fa-exclamation"></span> </strong>'+response.messages+
									'</div>')
								}
							} // /success
						}); // /ajax
					} // /if

					return false;
				});

			} // /success
		}); // /fetch selected member info

	} else {
		alert("Error : Refresh the page again");
	}

}