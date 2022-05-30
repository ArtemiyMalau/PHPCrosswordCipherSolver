@extends("general.layout")

@section("title", "Шифровочка")

@push("js_scripts")
	<script src="/js/index.js"></script>
@endpush

@section("main_content")
	<div class="site-block crossword_helper">
		<h3>Помощь в расшифровке кроссвордов</h3>
        <br>
		<form method="POST" action="{{ route('api.help') }}">
			@csrf
			<div class="form-group row">
				<div class="col-12 col-md-6">
					<h4 class="crossword_helper-h4">Настройка шифра</h4>
					<div class="form-group">
						<label class="col-form-label">Задайте используемый шифр:</label>
						<i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Шифр представляет собой набор цифр, где каждой цифре соответсвует список букв, одна из которых подставляется вместо указанной цифры."></i>
						<div id="cipher">
							<div class="row head-number-row">
								<div class="col-2">
									<small class="form-text text-muted">Число</small>
								</div>
								<div class="col">
									<small class="form-text text-muted">Подстановочные буквы</small>
								</div>
							</div>
							<div id="cipherNumbers">
						 	</div>
							<div class="row">
								<div class="col-12 col-md-6">
									<a href="##" class="form-link" js-add-number>Добавить число</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-12 col-md-6">
					<h4 class="crossword_helper-h4">Предполагаемое слово</h4>
					<div class="form-group">
						<label class="col-form-label">Укажите предполагаемое слово:</label>
						<i class="far fa-question-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="Слово должно состоять из букв кириллического алфавита. Недостающие буквы замените цифрами. Указанные цифры ограничивают подставляемую букву вариантами, перечисленными в шифре."></i>
						<input class="form-control" type="text" name="mask" placeholder="пример: б1йк1л">
					</div>
				</div>
			</div>
			<hr>
			<div class="form-group row">
		        <div class="col-12">
	            	<button class="btn btn-lg btn-primary" type="submit" data-toggle="modal" data-target="#save_schedule">Получить список слов</button>
		        </div>
		    </div>
		</form>
		{{-- Modals --}}
	    <div id="modalSuccess" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
		    <div class="modal-dialog" role="document" style="max-width:90%; width:600px;">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4 class="modal-title">Запрос на расшифровку</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                    <span aria-hidden="true">×</span>
		                </button>
		            </div>
		            <div class="modal-body">
    			        <div class="alert alert-success">
    			        	Список предполагаемых слов:
    			        	<div id="possibleWords"></div>
				        </div>
					</div>
					<div class="modal-footer">
			            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
		            </div>
	            </div>
            </div>
        </div>

	    <div id="modalFailure" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
		    <div class="modal-dialog" role="document" style="max-width:90%; width:600px;">
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4 class="modal-title">Запрос на расшифровку</h4>
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                    <span aria-hidden="true">×</span>
		                </button>
		            </div>
		            <div class="modal-body">
    			        <div class="alert alert-danger">
    			        	Не удалось запросить подсказку. Проверьте правильность заполнения полей.
				        </div>
					</div>
					<div class="modal-footer">
		                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
		            </div>
	            </div>
            </div>
        </div>
        {{-- Modals --}}
	</div>
@endsection