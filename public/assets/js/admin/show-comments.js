let selectedCommentId;
let replyForm = document.querySelector("form");
const deleteModal = document.getElementById('delete-comment-reply-modal')
const deleteModalClosebtn = deleteModal.querySelector(".btn-close")
const clickEvent = new Event('click')

deleteModal.addEventListener('show.bs.modal', (e) => {
    const rowDeleteBtn = e.relatedTarget
    const commentId = e.relatedTarget.dataset.commentId
    document.getElementById("modal-delete-comment-reply-btn").addEventListener('click', () => {

        deleteReply(commentId).then(
            response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error("reply couldn't be deleted");
                }
            }
        )

        deleteModalClosebtn.dispatchEvent(clickEvent);
    })
})

async function deleteReply(commentId) {
    return await fetch(`${apiBaseUrl}/admin/comments/${commentId}/deleteReply`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
    })
}

function openReplyModal(element, id) {
    const replyModal = new bootstrap.Modal('#reply-modal', {})
    replyModal.show();
    selectedCommentId = id;
}

const saveReply = async (e) => {
    e.preventDefault();

    const url = `${webBaseUrl}/api/admin/comments/${selectedCommentId}/reply`;
    const token = document.querySelector('input[name="_token"]').value;
    const replyMessage = document.querySelector('textarea[name="reply_message"]').value;
    const method = 'PATCH';

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({
                reply_message: replyMessage,
                _method: method
            })
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        window.location.reload();
    } catch (error) {
        // Handle errors (e.g., show error message)
        console.error('There was a problem with the fetch operation:', error);
    }
}