$(function () {

    $("#boardDeleteModal").on("shown.bs.modal", function (event) {
        let button = $(event.relatedTarget);
        let board = button.data("board");

        let modal = $(this);

        modal.find("#deleteBoardId").val(board["id"]);
        modal.find("#deleteBoardName").text(board["name"]);
    });

    $("#edit-board-modal").on("shown.bs.modal", function (event) {
        let button = $(event.relatedTarget);

        let modal = $(this);

        let board = button.data("board");
        // modal.find("#editBoardId").val(board["id"]);
        modal.find("#editBoardName").val(board["name"]);
       
    });
});

// $('#boardEditModal').on('shown.bs.modal', function(event) {
//     let button = $(event.relatedTarget); // Button that triggered the modal
//     let board = button.data('board');

//     let modal = $(this);

//     modal.find('#boardEditId').val(board.id);
//     modal.find('#boardEditName').text(board.name);

// });

// $(document).ready(function() {

//     $('#boardEditButtonAjax').on('click', function() {
//         $('#boardEditAlert').addClass('hidden');

//         let id = $('#boardEditIdAjax').val();
//         let role = $('#boardEditRoleAjax').val();

//         $.ajax({
//             method: 'POST',
//             url: '/board-update/' + id,
//             data: {role: role}
//         }).done(function(response) {
//             if (response.error !== '') {
//                 $('#boardEditAlert').text(response.error).removeClass('hidden');
//             } else {
//                 window.location.reload();
//             }
//         });
//     });

//     $('#boardDeleteButton').on('click', function() {
//         $('#boardDeleteAlert').addClass('hidden');
//         let id = $('#boardDeleteId').val();

//         $.ajax({
//             method: 'POST',
//             url: '/board/delete/' + id
//         }).done(function(response) {
//             if (response.error !== '') {
//                 $('#boardDeleteAlert').text(response.error).removeClass('hidden');
//             } else {
//                 window.location.reload();
//             }
//         });
//     });

//     $('#changeBoard').on('change', function() {
//         let id = $(this).val();
//         window.location.href = '/board/' + id;
//     });
// });