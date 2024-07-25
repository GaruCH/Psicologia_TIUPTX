class Loader {

    constructor(mainContainer = 'loader-container'){
        //We create the modal for the loader
        let html = `
        <div class="modal fade" id="loading-some" tabindex="-1" aria-labelledby="loading-some-title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="loader"></div>
                        <div class="loader-txt">
                            <h4>
                                <h4 id="title-loading-some"></h4>
                                <small id="body-loading-some"></small>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        //We add the loader to the container
        document.getElementById(mainContainer).innerHTML = html;

        //We instantiate our needed attributes
        this.loader = new bootstrap.Modal(document.getElementById('loading-some'));
        this.loaderTitle = document.getElementById('title-loading-some');
        this.loaderBody = document.getElementById('body-loading-some');
    }//end constructor básico

    setLoaderTitle(loaderTitle = 'Title'){
        this.loaderTitle.innerHTML = loaderTitle;
    }//end setLoaderTitle

    setLoaderBody(loaderBody = 'Body description'){
        this.loaderBody.innerHTML = loaderBody;
    }//end setLoaderTitle

    openLoader() {
        this.loader.show();
    }//end openLoader

    closeLoader(timingToClose = 100){
        let timer = setInterval(() => { this.loader.hide(); }, timingToClose);
        setTimeout(() => { clearInterval(timer); }, (500+timingToClose));
    }//end closeLoader

}//End Class Loader