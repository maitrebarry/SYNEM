<div class="parametres-section active">
    <h4 class="mb-4 text-synem-primary">
        <i class="bi bi-gear me-2"></i>Paramètres Généraux
    </h4>
    
    <div class="setting-card">
        <div class="setting-card-header">
            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations du Site</h5>
        </div>
        <div class="setting-card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nom du site</label>
                        <input type="text" class="form-control" value="SYNEM - Syndicat National des Enseignants du Mali">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Slogan</label>
                        <input type="text" class="form-control" value="Au service des enseignants maliens">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email de contact</label>
                        <input type="email" class="form-control" value="contact@synem.ml">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" class="form-control" value="+223 92190993">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <textarea class="form-control" rows="2">Bamako, Mali - Rue 123, Quartier du Fleuve</textarea>
            </div>
        </div>
    </div>
    
    <div class="setting-card">
        <div class="setting-card-header">
            <h5 class="mb-0"><i class="bi bi-sliders me-2"></i>Configuration</h5>
        </div>
        <div class="setting-card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Fuseau horaire</label>
                        <select class="form-select">
                            <option selected>Afrique/Bamako (UTC+0)</option>
                            <option>Europe/Paris (UTC+1)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Langue par défaut</label>
                        <select class="form-select">
                            <option selected>Français</option>
                            <option>Anglais</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="maintenanceMode" checked>
                <label class="form-check-label" for="maintenanceMode">
                    Mode maintenance
                </label>
            </div>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="userRegistration" checked>
                <label class="form-check-label" for="userRegistration">
                    Autoriser l'inscription des membres
                </label>
            </div>
        </div>
    </div>
</div>