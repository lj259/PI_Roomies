@extends('layouts.Plantilla1')
@section('titulo', 'Reportar Usuario')
@section('Contenido')

    <link rel="stylesheet" href="{{asset('css/reportes.css')}}">
    
    <style>
        .report-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .report-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .report-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        
        .report-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .report-body {
            padding: 2rem;
        }
        
        .reason-item {
            background: #f8f9ff;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .reason-item:hover {
            border-color: #4facfe;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.2);
        }
        
        .reason-item input[type="checkbox"] {
            transform: scale(1.2);
            margin-right: 1rem;
        }
        
        .reason-item.checked {
            border-color: #4facfe;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        
        .other-input {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s ease;
        }
        
        .other-input:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }
    </style>

    <div class="report-container">
        @if ($errors->has('general'))
            <div class="container">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ $errors->first('general') }}
                </div>
            </div>
        @endif

        <div class="container">
            <div class="report-card">
                <div class="report-header">
                    <div class="report-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h2 class="mb-0">Reportar Usuario</h2>
                    <p class="mb-0 mt-2 opacity-75">Ayúdanos a mantener una comunidad segura</p>
                </div>
                
                <div class="report-body">
                    <form method="POST" action="/ValidarReportes" id="reportForm">
                        @csrf
                        
                        <div class="mb-4">
                            <h5 class="mb-4 text-dark font-weight-bold">
                                <i class="fas fa-exclamation-circle text-warning mr-2"></i>
                                Selecciona la razón del reporte
                            </h5>
                            
                            <div class="reasons-container">
                                <div class="reason-item" onclick="toggleReason(this, 'chbox1')">
                                    <label class="d-flex align-items-start mb-0 cursor-pointer">
                                        <input type="checkbox" name="chbox1" class="mt-1">
                                        <div>
                                            <strong>Contenido inapropiado</strong>
                                            <p class="mb-0 text-muted small mt-1">
                                                Publicación de contenido ofensivo, inapropiado, difamatorio o amenazante.
                                            </p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="reason-item" onclick="toggleReason(this, 'chbox2')">
                                    <label class="d-flex align-items-start mb-0 cursor-pointer">
                                        <input type="checkbox" name="chbox2" class="mt-1">
                                        <div>
                                            <strong>Acoso o intimidación</strong>
                                            <p class="mb-0 text-muted small mt-1">
                                                Envío de mensajes de odio, acoso o intimidación a otros usuarios.
                                            </p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="reason-item" onclick="toggleReason(this, 'chbox3')">
                                    <label class="d-flex align-items-start mb-0 cursor-pointer">
                                        <input type="checkbox" name="chbox3" class="mt-1">
                                        <div>
                                            <strong>Fraude o engaño</strong>
                                            <p class="mb-0 text-muted small mt-1">
                                                Difusión de rumores, enlaces con malware o intentos de estafa.
                                            </p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="reason-item" onclick="toggleReason(this, 'chbox4')">
                                    <label class="d-flex align-items-start mb-0 cursor-pointer">
                                        <input type="checkbox" name="chbox4" class="mt-1">
                                        <div>
                                            <strong>Suplantación de identidad</strong>
                                            <p class="mb-0 text-muted small mt-1">
                                                Hacerse pasar por otra persona sin su consentimiento.
                                            </p>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="reason-item" onclick="toggleReason(this, 'chbox5')">
                                    <label class="d-flex align-items-start mb-0 cursor-pointer">
                                        <input type="checkbox" name="chbox5" class="mt-1">
                                        <div>
                                            <strong>Spam</strong>
                                            <p class="mb-0 text-muted small mt-1">
                                                Envío de mensajes no solicitados de manera masiva.
                                            </p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="other" class="font-weight-bold mb-2 d-block">
                                <i class="fas fa-edit text-info mr-2"></i>
                                Descripción adicional (opcional)
                            </label>
                            <textarea 
                                name="other" 
                                id="other"
                                class="form-control other-input" 
                                rows="4"
                                placeholder="Proporciona más detalles sobre tu reporte..."
                            ></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="submit-btn btn">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Enviar Reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleReason(element, checkboxName) {
            const checkbox = element.querySelector(`input[name="${checkboxName}"]`);
            checkbox.checked = !checkbox.checked;
            
            if (checkbox.checked) {
                element.classList.add('checked');
            } else {
                element.classList.remove('checked');
            }
        }
        
        // Form validation
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            const checkboxes = this.querySelectorAll('input[type="checkbox"]');
            const otherText = this.querySelector('textarea[name="other"]').value.trim();
            
            let hasSelection = false;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    hasSelection = true;
                }
            });
            
            if (!hasSelection && !otherText) {
                e.preventDefault();
                alert('Por favor, selecciona al menos una razón de reporte o proporciona una descripción adicional.');
            }
        });
    </script>
@endsection