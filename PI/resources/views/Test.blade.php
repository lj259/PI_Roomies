@extends('layouts.plantilla_simple')
@section('titulo', 'Test')
@section('Contenido')
@if(session('Exito'))
    <script>
        Swal.fire({
            title: "Respuesta del Servidor!",
            text: '{{session('Exito')}}',
            icon: "success"
        });
    </script>
@endif

<div class="container mt-4 min-vh-100">
    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
        <div class="table-responsive col-md-7">
            <h2 class="mb-3">Test de Compatibilidad de Hábitos</h2>
            <form action="{{route('ValidarTest')}}" method="POST" id="testForm">
                @csrf
                <table class="table">
                    <thead class="table-primary">
                        <tr>
                            <th width="60%">TEST HÁBITOS</th>
                            <th>SI</th>
                            <th>NO</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>¿Te causa alguna incomodidad tener un compañero del sexo opuesto?</td>
                            <td><input type="radio" name="q1" id="q1_si" value="si" class="form-check-input" required></td>
                            <td><input type="radio" name="q1" id="q1_no" value="no" class="form-check-input"></td>
                            <td class="error-cell"><small class="text-danger">{{$errors->first('q1')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Te consideras una persona ordenada?</td>
                            <td><input type="radio" name="q2" id="q2_si" value="si" class="form-check-input" required></td>
                            <td><input type="radio" name="q2" id="q2_no" value="no" class="form-check-input"></td>
                            <td class="error-cell"><small class="text-danger">{{$errors->first('q2')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Te molesta el ruido por la noche? o despues de cierto horario</td>
                            <td><input type="radio" name="q3" id="q3_si" value="si" class="form-check-input" required></td>
                            <td><input type="radio" name="q3" id="q3_no" value="no" class="form-check-input"></td>
                            <td class="error-cell"><small class="text-danger">{{$errors->first('q3')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Tienes alguna mascota?</td>
                            <td><input type="radio" name="q4" id="q4_si" value="si" class="form-check-input" required></td>
                            <td><input type="radio" name="q4" id="q4_no" value="no" class="form-check-input"></td>
                            <td class="error-cell"><small class="text-danger">{{$errors->first('q4')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Fumas con frecuencia?</td>
                            <td><input type="radio" name="q5" id="q6_si" value="si" class="form-check-input" required></td>
                            <td><input type="radio" name="q5" id="q6_no" value="no" class="form-check-input"></td>
                            <td class="error-cell"><small class="text-danger">{{$errors->first('q5')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Te podria llegar a molestar, compartir utensilios de cocina?</td>
                            <td><input type="radio" name="q6" id="q6_si" value="si" class="form-check-input" required></td>
                            <td><input type="radio" name="q6" id="q6_no" value="no" class="form-check-input"></td>
                            <td class="error-cell"><small class="text-danger">{{$errors->first('q6')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Cuentas con algun vehiculo?</td>
                            <td><input type="radio" name="q7" id="q7_si" value="si" class="form-check-input" required></td>
                            <td><input type="radio" name="q7" id="q7_no" value="no" class="form-check-input"></td>
                            <td class="error-cell"><small class="text-danger">{{$errors->first('q7')}}</small></td>
                        </tr>
                        <tr>
                            <td>¿Tendrias algun problema en estar con un compañero del sexo opuesto?</td>
                            <td><input type="radio" name="q8" id="q8_si" value="si" class="form-check-input" required></td>
                            <td><input type="radio" name="q8" id="q8_no" value="no" class="form-check-input"></td>
                            <td class="error-cell"><small class="text-danger">{{$errors->first('q8')}}</small></td>
                        </tr>
                    </tbody>
                </table>
                <div class="progress mb-3">
                    <div class="progress-bar" role="progressbar" id="formProgress" style="width: 0%"></div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-info m-2">ENVIAR RESPUESTAS</button>
                </div>
            </form>
        </div>

        <div class="col-md-4 d-flex flex-column justify-content-start align-items-center mt-4 mt-md-0">
            <img src="{{asset('images/Polo2.png')}}" alt="Polo" class="img-fluid" style="max-width: 450px; width: 50%;">
            <p class="text-center mt-3">Queremos conocerte mejor, esto nos permitira mostrarte mejores preferencias de busqueda en base a tus necesidades</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form progress tracker
        const form = document.getElementById('testForm');
        const radios = form.querySelectorAll('input[type="radio"]');
        const progressBar = document.getElementById('formProgress');
        const resetBtn = document.getElementById('resetBtn');
        
        // Update progress when radio buttons are clicked
        radios.forEach(radio => {
            radio.addEventListener('change', updateProgress);
        });
        
        // Reset button functionality
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                if(confirm('¿Estás seguro de que quieres limpiar todas tus respuestas?')) {
                    form.reset();
                    updateProgress();
                }
            });
        }
        
        // Add reset button if it doesn't exist
        if (!resetBtn) {
            const buttonContainer = form.querySelector('.text-center');
            const newResetBtn = document.createElement('button');
            newResetBtn.type = 'button';
            newResetBtn.className = 'btn btn-warning m-2';
            newResetBtn.id = 'resetBtn';
            newResetBtn.textContent = 'LIMPIAR RESPUESTAS';
            newResetBtn.addEventListener('click', function() {
                if(confirm('¿Estás seguro de que quieres limpiar todas tus respuestas?')) {
                    form.reset();
                    updateProgress();
                }
            });
            buttonContainer.appendChild(newResetBtn);
        }
        
        function updateProgress() {
            const totalQuestions = 8;
            const answeredQuestions = [...new Set(
                Array.from(form.querySelectorAll('input[type="radio"]:checked'))
                    .map(radio => radio.name)
            )].length;
            
            const percentage = (answeredQuestions / totalQuestions) * 100;
            progressBar.style.width = percentage + '%';
            progressBar.textContent = Math.round(percentage) + '%';
        }
        
        // Check localStorage for saved progress
        const savedProgress = localStorage.getItem('testFormProgress');
        if (savedProgress) {
            const savedAnswers = JSON.parse(savedProgress);
            for (const [name, value] of Object.entries(savedAnswers)) {
                const radio = form.querySelector(`input[name="${name}"][value="${value}"]`);
                if (radio) radio.checked = true;
            }
        }
        
        // Save progress to localStorage when form changes
        radios.forEach(radio => {
            radio.addEventListener('change', saveProgress);
        });
        
        function saveProgress() {
            const answers = {};
            form.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                answers[radio.name] = radio.value;
            });
            localStorage.setItem('testFormProgress', JSON.stringify(answers));
        }
        
        // Clear localStorage when form is submitted
        form.addEventListener('submit', function() {
            localStorage.removeItem('testFormProgress');
        });
        
        // Initial progress calculation
        updateProgress();
    });
</script>
@endsection
