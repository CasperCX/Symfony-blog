const blogposts = document.getElementById('blogposts');

if (blogposts) {
    blogposts.addEventListener('click', e => {
        if(e.target.className === 'btn btn-danger delete-blog') {
            //Get id as data-id prop
            const id = e.target.getAttribute('data-id');
            
            //Query the backend
            fetch(`/blog/delete/${id}`, {
                method: 'DELETE'
            }).then(res => window.location.reload());
        }
    })
}