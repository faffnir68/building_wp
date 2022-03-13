
// Quick load more posts
const showNextBreweries = document.querySelector(".btn-show-next-breweries")
const breweriesList = document.querySelector('.breweries-list')

let PER_PAGE = 20

if(showNextBreweries !== null) {
    showNextBreweries.addEventListener('click', () => {
        // The XMLHttpRequest way ---> the old way

        // const request = new XMLHttpRequest();
        // request.open("GET", `${wpApiSettings.restURL}/wp-json/wp/v2/brewery/?per_page=${PER_PAGE}`);
        // request.onload = function() {
        //         if(request.status >= 200 && request.status < 400) {
        //                 let data = JSON.parse(request.responseText)
        //                 createHTML(data)
        //             }
        //             else {
        //                     console.log("We connected to the server and error was returned")
        //     }
        // }
        // request.onerror = function() {
        //         console.log("Connection error")
        //     }
        //     request.send()

        // The fetch way ---> the modern way
            fetch(`${wpApiSettings.restURL}/wp-json/wp/v2/brewery/?per_page=${PER_PAGE}`, {
                headers: {'Content-type': 'application/json'},
            })
            .then((response) => {
                PER_PAGE += 10
                response.json()
            .then(data => {
                createHTML(data)
            })
        })
    })
}

function createHTML(postsData) {
    let ourHTMLString = "";
    postsData.forEach(postData => {
        ourHTMLString += `<li>${postData.title.rendered}</li>`
        console.log(postData)
        return ourHTMLString
    })
    breweriesList.innerHTML = ourHTMLString
}


// Quick add post ajax
const addBtn = document.querySelector(".btn-add-brewery")
if(addBtn !== null) {
    addBtn.addEventListener("click", () => {
        const postData = {
            "title": document.querySelector('.add-brewery-box input[name=title]').value,
            "content": document.querySelector('.add-brewery-box textarea[name=content]').value,
            "status": "publish"
        }

        // The XMLHttpRequest way ---> the old way

        // const createPost = new XMLHttpRequest();
        // createPost.open('POST', `${wpApiSettings.restURL}/wp-json/wp/v2/brewery/`);
        // // createPost.setRequestHeader('same-origin');
        // createPost.setRequestHeader("X-WP-nonce", wpApiSettings.nonce);
        // createPost.setRequestHeader(
        //     "Content-type", 
        //     "application/json;charset=UTF-8", 
        //     'Access-Control-Allow-Origin:*');
        // createPost.send(JSON.stringify(postData));
        // createPost.onreadystatechange = () => {
        //     if(createPost.readyState === 4) {
        //         if(createPost.status === 201) {
        //             document.querySelector('.add-brewery-box input[name=title]').value = "";
        //             document.querySelector('.add-brewery-box textarea[name=content]').value = "";
        //         } else {
        //             alert("Error");
        //         }
        //     }
        // }

        // The fetch way ---> the modern way

        fetch("http://find-a-brewer.test/wp-json/wp/v2/brewery/", {
            method: 'POST',
            credentials: 'same-origin',
            headers: new Headers({'Content-type': 'application/json; charset=UTF-8', 
                    // "Accept": "application/json",
                    // "Access-Control-Allow-Origin" : "*", 
                    // "Access-Control-Allow-Credentials" : true,
                    'X-WP-Nonce' :  wpApiSettings.nonce
            }),
            body: JSON.stringify(postData)
        })
        .then((response) => {
            if(!response.ok) {
                throw new Error(response.status)
            }
            else {
                document.querySelector('.add-brewery-box input[name=title]').value = "";
                document.querySelector('.add-brewery-box textarea[name=content]').value = "";
            }
        })
        .catch((error) => {
            console.log(error)
        })
    })
}