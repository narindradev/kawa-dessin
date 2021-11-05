<x-base-layout>
   
    <div class="row">
        <div class="col-3" >
            <div class="card card-custom">
                <div class="card-header align-items-center px-4 py-3">
                    <h3 class="card-title">Paramètres</h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs nav-pills flex-row border-0  flex-md-column ">
                        <li class="nav-item me-2 mb-2">
                            <a class="nav-link btn btn-active-light-primary active" data-loal-url="{{ url("/app/setting/general") }}" data-toggle="ajax-tab" data-bs-toggle="tab" href="#general">
                               
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-5 fw-bolder"><i class="fas fa-tools fs-2 text-primary"></i>General</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item me-2 mb-2">
                            <a class="nav-link btn btn-active-light-primary " data-toggle="ajax-tab" data-bs-toggle="tab" href="#api">
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bolder"><i class="fas fa-key fs-2 text-primary"></i>Clé API</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item me-2 mb-2">
                            <a class="nav-link btn  btn-active-light-primary" data-loal-url="{{ url("/app/setting/payment_method") }}" data-toggle="ajax-tab" data-bs-toggle="tab" href="#payment">
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bolder"><i class="fas fa-credit-card fs-2 text-primary"></i>Methode de paiments</span>
                            </a>
                        </li>
                        <li class="nav-item me-2 mb-2">
                            <a class="nav-link btn  btn-active-light-primary" data-toggle="ajax-tab" data-bs-toggle="tab" href="#project">
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bolder"><i class="fas fa-briefcase fs-2 text-primary"></i>Projets</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn  btn-active-light-primary" data-toggle="ajax-tab" data-bs-toggle="tab" href="#notification" data-loal-url="{{ url("/app/setting/notification") }}">
                                <span class="d-flex flex-column align-items-start">
                                    <span class="fs-4 fw-bolder"><i class="fas fa-bell fs-2 text-primary"></i>Notification</span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9" >
            <div class="card card-custom h-600px">
                <div class="card-header align-items-center px-4 py-3">
                </div>
                <div class="card-body">
                    <div class="tab-content" id="ajax-tab-content">
                        <div class="tab-pane fade active show" id="general" role="tabpanel"></div>
                        <div class="tab-pane fade" id="api" role="tabpanel"></div>
                        <div class="tab-pane fade" id="payment" role="tabpanel"></div>
                        <div class="tab-pane fade" id="project" role="tabpanel"></div>
                        <div class="tab-pane fade" id="notification" role="tabpanel"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>