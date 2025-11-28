document.addEventListener("DOMContentLoaded", function() {

	//fancybox
	Fancybox.bind("[data-fancybox]", {
		//settings
	});


	//files add
	const fileBlocks = document.querySelectorAll('.js-field-file');
	
	fileBlocks.forEach(fileBlock => {
		const fileInput = fileBlock.querySelector('.js-field-input');
		const fileAttachButton = fileBlock.querySelector('.js-file-button-attach');
		const fileDeleteButton = fileBlock.querySelector('.js-file-button-del');
		const fileName = fileBlock.querySelector('.file-name');
	
		fileAttachButton.addEventListener('click', function() {
			fileInput.click();
		});
	
		fileInput.addEventListener('change', function() {
			if (fileInput.files.length > 0) {
				fileName.textContent = fileInput.files[0].name;
				fileBlock.classList.add('file-active');
			} else {
				fileName.textContent = '';
				fileBlock.classList.remove('file-active');
			}
		});
	
		fileDeleteButton.addEventListener('click', function(e) {
			e.preventDefault();
			fileName.textContent = '';
			fileBlock.classList.remove('file-active');
			fileInput.value = null;
		});
	});

	

	//btn tgl and add
	let tglButtons = document.querySelectorAll('.js-btn-tgl')
	let addButtons = document.querySelectorAll('.js-btn-add')
	let buttonsTglOne = document.querySelectorAll('.js-btn-tgl-one');
	for (i = 0;i < tglButtons.length;i++) {
		tglButtons[i].addEventListener('click', function(e) {
			this.classList.contains('active') ? this.classList.remove('active') : this.classList.add('active')
			e.preventDefault()
			return false
		})
	}
	for (i = 0;i < addButtons.length;i++) {
		addButtons[i].addEventListener('click', function(e) {
			if (!this.classList.contains('active')) {
				this.classList.add('active');
				e.preventDefault()
				return false
			}
		})
	}
	buttonsTglOne.forEach(function(button) {
		button.addEventListener('click', function(e) {
			e.preventDefault();
			let toggleButtonsWrap = this.closest('.js-toggle-buttons');
	
			if (this.classList.contains('active')) {
				this.classList.remove('active');
			} else {
				toggleButtonsWrap.querySelectorAll('.js-btn-tgl-one').forEach(function(btn) {
					btn.classList.remove('active');
				});
				this.classList.add('active');
			}
			return false;
		});
	});


	//js popup wrap
	const togglePopupButtons = document.querySelectorAll('.js-btn-popup-toggle')
	const closePopupButtons = document.querySelectorAll('.js-btn-popup-close')
	const popupElements = document.querySelectorAll('.js-popup-wrap')
	const wrapWidth = document.querySelector('.wrap').offsetWidth
	const bodyElem = document.querySelector('body')
	function popupElementsClear() {
		document.body.classList.remove('menu-show')
		document.body.classList.remove('filter-show')
		document.body.classList.remove('search-show')
		popupElements.forEach(element => element.classList.remove('popup-right'))
	}
	function popupElementsClose() {
		togglePopupButtons.forEach(element => {
			if (window.innerWidth < 1024) {
				if (!element.closest('.no-close-mobile') && !element.closest('.no-close')) {
					element.classList.remove('active')
				}

			} else if  (window.innerWidth > 1023) {
				if (!element.closest('.no-close-desktop') && !element.closest('.no-close')) {
					element.classList.remove('active')
				}
			} else {
				if (!element.closest('.no-close')) {
					element.classList.remove('active')
				}
			}
		})
	}
	function popupElementsContentPositionClass() {
		popupElements.forEach(element => {
			let pLeft = element.offsetLeft
			let pWidth = element.querySelector('.js-popup-block').offsetWidth
			let pMax = pLeft + pWidth;
			if (pMax > wrapWidth) {
				element.classList.add('popup-right')
			} else {
				element.classList.remove('popup-right')
			}
		})
	}
	for (i = 0; i < togglePopupButtons.length; i++) {
		togglePopupButtons[i].addEventListener('click', function (e) {
			popupElementsClear()
			if (this.classList.contains('active')) {
				this.classList.remove('active')
			} else {
				popupElementsClose()
				this.classList.add('active')
				if (this.closest('.popup-menu-wrap')) {
					document.body.classList.add('menu-show')
				}
				if (this.closest('.popup-search-wrap')) {
					document.body.classList.add('search-show')
				}
				if (this.closest('.popup-filter-wrap')) {
					document.body.classList.add('filter-show')
				}
				popupElementsContentPositionClass()
			}
			e.preventDefault()
			e.stopPropagation()
			return false
		})
	}
	for (i = 0; i < closePopupButtons.length; i++) {
		closePopupButtons[i].addEventListener('click', function (e) {
			popupElementsClear()
			popupElementsClose()
			e.preventDefault()
			e.stopPropagation()
			return false;
		})
	}
	document.onclick = function (event) {
		if (!event.target.closest('.js-popup-block')) {
			popupElementsClear()
			popupElementsClose()
		}
	}
	popupElements.forEach(element => {
		if (element.classList.contains('js-popup-select')) {
			let popupElementSelectItem = element.querySelectorAll('.js-popup-block li a')
			if (element.querySelector('.js-popup-block .active')) {
				element.classList.add('select-active')
				let popupElementActive = element.querySelector('.js-popup-block .active').innerHTML
				let popupElementButton = element.querySelector('.js-btn-popup-toggle')
				popupElementButton.innerHTML = ''
				popupElementButton.insertAdjacentHTML('beforeend', popupElementActive)
			} else {
				element.classList.remove('select-active')
			}
			for (i = 0; i < popupElementSelectItem.length; i++) {
				popupElementSelectItem[i].addEventListener('click', function (e) {
					this.closest('.js-popup-wrap').classList.add('select-active')
					if (this.closest('.js-popup-wrap').querySelector('.js-popup-block .active')) {
						this.closest('.js-popup-wrap').querySelector('.js-popup-block .active').classList.remove('active')
					}
					this.classList.add('active')
					let popupElementActive = element.querySelector('.js-popup-block .active').innerHTML
					let popupElementButton = element.querySelector('.js-btn-popup-toggle')
					popupElementButton.innerHTML = ''
					popupElementButton.insertAdjacentHTML('beforeend', popupElementActive)
					popupElementsClear()
					popupElementsClose()
					if (!this.closest('.js-tabs-nav')) {
						e.preventDefault()
						e.stopPropagation()
						return false
					}
				})
			}
		}
	})



	// Reviews page AJAX - кнопка "Показать еще"
	// Используем делегирование событий для надежности
	let reviewsIsLoading = false; // Флаг для отслеживания состояния загрузки
	
	// Функция для обработки клика
	function handleReviewsLoadMore(e) {
		const button = e.target.closest('.js-reviews-load-more');
		if (!button) return;
		
		e.preventDefault();
		
		// Проверяем наличие необходимых элементов
		const reviewsContainer = document.querySelector('.tiles-box .items-wrap');
		if (!reviewsContainer || typeof zamok01_ajax === 'undefined') {
			console.error('Не найдены необходимые элементы или zamok01_ajax не определен');
			return;
		}
		
		// Проверяем, не идет ли уже загрузка
		if (reviewsIsLoading) {
			console.log('Загрузка уже идет, пропускаем клик');
			return;
		}
		
		const currentPage = parseInt(button.getAttribute('data-page')) || 1;
		const nextPage = currentPage + 1;
		const totalPages = parseInt(button.getAttribute('data-total-pages')) || 1;
		
		console.log('Клик по кнопке. Текущая страница:', currentPage, 'Следующая:', nextPage, 'Всего страниц:', totalPages);
		
		if (nextPage > totalPages) {
			button.style.display = 'none';
			return;
		}
		
		// Устанавливаем флаг загрузки
		reviewsIsLoading = true;
		
		// Показываем индикатор загрузки
		if (reviewsContainer) {
			reviewsContainer.style.opacity = '0.5';
			reviewsContainer.style.pointerEvents = 'none';
		}
		
		// Блокируем кнопку
		button.style.pointerEvents = 'none';
		button.disabled = true;
		const buttonTitle = button.querySelector('.button-title');
		const originalText = buttonTitle ? buttonTitle.textContent : 'Показать еще';
		if (buttonTitle) {
			buttonTitle.textContent = 'Загрузка...';
		}
		
		const formData = new FormData();
		formData.append('action', 'load_reviews');
		formData.append('page', nextPage);
		formData.append('nonce', zamok01_ajax.nonce);
		
		fetch(zamok01_ajax.ajax_url, {
			method: 'POST',
			body: formData
		})
		.then(response => {
			console.log('Ответ получен, статус:', response.status);
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return response.json();
		})
		.then(data => {
			console.log('Данные получены:', data);
			if (data.success) {
				// Добавляем новые отзывы к существующим
				if (reviewsContainer && data.data.reviews) {
					reviewsContainer.insertAdjacentHTML('beforeend', data.data.reviews);
					console.log('Отзывы добавлены, всего символов HTML:', data.data.reviews.length);
				}
				
				// Всегда обновляем data-page после успешной загрузки
				button.setAttribute('data-page', nextPage);
				console.log('data-page обновлен на:', nextPage);
				
				// Обновляем кнопку "Показать еще"
				if (data.data.has_more) {
					if (buttonTitle) {
						buttonTitle.textContent = originalText;
					}
					button.style.display = '';
					console.log('Есть еще страницы, кнопка остается видимой');
				} else {
					button.style.display = 'none';
					console.log('Больше нет страниц, кнопка скрыта');
				}
			} else {
				console.error('Запрос не успешен:', data);
				// Если запрос не успешен, возвращаем текст кнопки
				if (buttonTitle) {
					buttonTitle.textContent = originalText;
				}
			}
		})
		.catch(error => {
			console.error('Ошибка загрузки отзывов:', error);
			if (buttonTitle) {
				buttonTitle.textContent = originalText;
			}
		})
		.finally(() => {
			// Сбрасываем флаг загрузки
			reviewsIsLoading = false;
			
			// Убираем индикатор загрузки
			if (reviewsContainer) {
				reviewsContainer.style.opacity = '1';
				reviewsContainer.style.pointerEvents = 'auto';
			}
			button.style.pointerEvents = 'auto';
			button.disabled = false;
		});
	}
	
	// Привязываем обработчик через делегирование событий
	document.addEventListener('click', handleReviewsLoadMore);

	// Popups
	let popupCurrent;
	let popupsList = document.querySelectorAll('.popup-outer-box')

	document.querySelectorAll(".js-popup-open").forEach(function (element) {
	element.addEventListener("click", function (e) {
		document.querySelector(".popup-outer-box").classList.remove("active");
		document.body.classList.add("popup-open");
		for (i=0;i<popupsList.length;i++) {
			popupsList[i
				].classList.remove("active");
			}

		popupCurrent = this.getAttribute("data-popup");
		document
		.querySelector(
			`.popup-outer-box[id="${popupCurrent}"
			]`
		)
		.classList.add("active");

		e.preventDefault();
		e.stopPropagation();
		return false;
		});
	});
	document.querySelectorAll(".js-popup-close").forEach(function (element) {
	element.addEventListener("click", function (event) {
		document.body.classList.remove("popup-open");
		for (i=0;i<popupsList.length;i++) {
			popupsList[i
				].classList.remove("active");
			}
		event.preventDefault();
		event.stopPropagation();
		});
	});
	document.querySelectorAll(".popup-outer-box").forEach(function (element) {
	element.addEventListener("click", function (event) {
		if (!event.target.closest(".popup-box")) {
		document.body.classList.remove("popup-open");
		document.body.classList.remove("popup-open-scroll");
		document.querySelectorAll(".popup-outer-box").forEach(function (e) {
			e.classList.remove("active");
				});
		return false;
			}
		});
	});


	//slider tiles
	const sliderstiles = document.querySelectorAll(".slider-tiles");
	
	sliderstiles.forEach((container) => {
		const swiperEl = container.querySelector(".swiper");
		const nextEl = container.querySelector(".button-slider-tiles-next");
		const prevEl = container.querySelector(".button-slider-tiles-prev");
	
		if (!swiperEl) return;
	
		new Swiper(swiperEl, {
			loop: false,
			slidesPerGroup: 1,
			slidesPerView: 1,
			spaceBetween: 0,
			autoHeight: true,
			speed: 400,
			pagination: false,
			autoplay: false,
			navigation: {
				nextEl: nextEl,
				prevEl: prevEl,
			},
			breakpoints: {
				768: { slidesPerView: 2, autoHeight: false, },
				1200: { slidesPerView: 3, autoHeight: false, },
			},
		});
	});

	// Articles tabs AJAX
	const articleTabs = document.querySelectorAll('.js-article-tab');
	const articlesContainer = document.querySelector('.js-articles-container');
	const articlesPagination = document.querySelector('.js-articles-pagination');
	
	if (articleTabs.length > 0 && articlesContainer) {
		articleTabs.forEach(function(tab) {
			tab.addEventListener('click', function(e) {
				e.preventDefault();
				
				// Убираем активный класс со всех табов
				articleTabs.forEach(function(t) {
					t.classList.remove('active');
				});
				
				// Добавляем активный класс к текущему табу
				this.classList.add('active');
				
				// Получаем ID категории
				const categoryId = this.getAttribute('data-category-id');
				
				// Показываем индикатор загрузки
				const itemsWrap = articlesContainer.querySelector('.items-wrap');
				if (itemsWrap) {
					itemsWrap.style.opacity = '0.5';
					itemsWrap.style.pointerEvents = 'none';
				}
				
				// AJAX запрос
				if (typeof zamok01_ajax !== 'undefined') {
					const formData = new FormData();
					formData.append('action', 'load_articles');
					formData.append('category_id', categoryId);
					formData.append('page', 1);
					formData.append('nonce', zamok01_ajax.nonce);
					
					fetch(zamok01_ajax.ajax_url, {
						method: 'POST',
						body: formData
					})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							// Обновляем контент статей
							if (itemsWrap && data.data.articles) {
								itemsWrap.innerHTML = data.data.articles;
							}
							
							// Обновляем пагинацию
							if (articlesPagination && data.data.pagination) {
								articlesPagination.innerHTML = data.data.pagination;
							}
							
							// Обновляем URL без перезагрузки страницы
							const categorySlug = this.getAttribute('data-category-slug');
							const baseUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
							const newUrl = categoryId == 0 ? baseUrl : baseUrl + '?category=' + categorySlug;
							window.history.pushState({ category: categoryId }, '', newUrl);
						}
					})
					.catch(error => {
						console.error('Ошибка загрузки статей:', error);
					})
					.finally(() => {
						// Убираем индикатор загрузки
						if (itemsWrap) {
							itemsWrap.style.opacity = '1';
							itemsWrap.style.pointerEvents = 'auto';
						}
					});
				}
			});
		});
		
		// Обработка пагинации через AJAX
		if (articlesPagination) {
			articlesPagination.addEventListener('click', function(e) {
				const link = e.target.closest('a');
				if (link && link.href && !link.classList.contains('js-article-tab')) {
					e.preventDefault();
					
					// Получаем номер страницы из URL или из текста ссылки
					let page = 1;
					try {
						const url = new URL(link.href);
						if (url.searchParams.has('paged')) {
							page = parseInt(url.searchParams.get('paged')) || 1;
						} else {
							// Пытаемся получить из текста ссылки
							const pageMatch = link.textContent.match(/\d+/);
							if (pageMatch) {
								page = parseInt(pageMatch[0]);
							}
						}
					} catch (err) {
						// Если не удалось распарсить URL, пытаемся получить из текста или класса
						const pageMatch = link.textContent.match(/\d+/);
						if (pageMatch) {
							page = parseInt(pageMatch[0]);
						} else if (link.classList.contains('next')) {
							// Если это кнопка "следующая", получаем текущую страницу и добавляем 1
							const currentPageEl = articlesPagination.querySelector('.page-numbers.current');
							if (currentPageEl) {
								page = parseInt(currentPageEl.textContent) + 1;
							}
						} else if (link.classList.contains('prev')) {
							// Если это кнопка "предыдущая", получаем текущую страницу и вычитаем 1
							const currentPageEl = articlesPagination.querySelector('.page-numbers.current');
							if (currentPageEl) {
								page = Math.max(1, parseInt(currentPageEl.textContent) - 1);
							}
						}
					}
					
					// Получаем активную категорию
					const activeTab = document.querySelector('.js-article-tab.active');
					if (activeTab && typeof zamok01_ajax !== 'undefined') {
						const categoryId = activeTab.getAttribute('data-category-id');
						
						const itemsWrap = articlesContainer.querySelector('.items-wrap');
						if (itemsWrap) {
							itemsWrap.style.opacity = '0.5';
							itemsWrap.style.pointerEvents = 'none';
						}
						
						const formData = new FormData();
						formData.append('action', 'load_articles');
						formData.append('category_id', categoryId);
						formData.append('page', page);
						formData.append('nonce', zamok01_ajax.nonce);
						
						fetch(zamok01_ajax.ajax_url, {
							method: 'POST',
							body: formData
						})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								if (itemsWrap && data.data.articles) {
									itemsWrap.innerHTML = data.data.articles;
								}
								
								if (articlesPagination && data.data.pagination) {
									articlesPagination.innerHTML = data.data.pagination;
								}
							}
						})
						.catch(error => {
							console.error('Ошибка загрузки статей:', error);
						})
						.finally(() => {
							if (itemsWrap) {
								itemsWrap.style.opacity = '1';
								itemsWrap.style.pointerEvents = 'auto';
							}
						});
					}
				}
			});
		}
		
		// Обработка кнопки "Развернуть еще"
		const moreButton = document.querySelector('.more-inner-wrap .btn');
		if (moreButton && !moreButton.classList.contains('js-article-tab')) {
			moreButton.addEventListener('click', function(e) {
				e.preventDefault();
				
				const activeTab = document.querySelector('.js-article-tab.active');
				if (activeTab && typeof zamok01_ajax !== 'undefined') {
					const categoryId = activeTab.getAttribute('data-category-id');
					
					// Получаем текущую страницу из пагинации
					const currentPage = articlesPagination ? 
						(parseInt(articlesPagination.querySelector('.page-numbers.current')?.textContent) || 1) : 1;
					const nextPage = currentPage + 1;
					
					const itemsWrap = articlesContainer.querySelector('.items-wrap');
					if (itemsWrap) {
						itemsWrap.style.opacity = '0.5';
						itemsWrap.style.pointerEvents = 'none';
					}
					
					const formData = new FormData();
					formData.append('action', 'load_articles');
					formData.append('category_id', categoryId);
					formData.append('page', nextPage);
					formData.append('nonce', zamok01_ajax.nonce);
					
					fetch(zamok01_ajax.ajax_url, {
						method: 'POST',
						body: formData
					})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							if (itemsWrap && data.data.articles) {
								// Добавляем новые статьи к существующим
								itemsWrap.insertAdjacentHTML('beforeend', data.data.articles);
							}
							
							if (articlesPagination && data.data.pagination) {
								articlesPagination.innerHTML = data.data.pagination;
							}
						}
					})
					.catch(error => {
						console.error('Ошибка загрузки статей:', error);
					})
					.finally(() => {
						if (itemsWrap) {
							itemsWrap.style.opacity = '1';
							itemsWrap.style.pointerEvents = 'auto';
						}
					});
				}
			});
		}
	}

	// Phone mask
	const phoneInputs = document.querySelectorAll('.js-phone-mask');
	phoneInputs.forEach(function(input) {
		// Устанавливаем начальное значение
		input.value = '';
		
		input.addEventListener('input', function(e) {
			let value = this.value.replace(/\D/g, '');
			
			// Ограничиваем длину до 11 цифр
			if (value.length > 11) {
				value = value.substring(0, 11);
			}
			
			if (value.length > 0) {
				// Если начинается с 8, заменяем на 7
				if (value[0] === '8') {
					value = '7' + value.substring(1);
				}
				// Если не начинается с 7, добавляем 7 в начало
				if (value[0] !== '7') {
					value = '7' + value;
				}
			}
			
			let formattedValue = '';
			if (value.length > 0) {
				formattedValue = '+7';
				if (value.length > 1) {
					formattedValue += ' (' + value.substring(1, 4);
				}
				if (value.length >= 4) {
					formattedValue += ') ' + value.substring(4, 7);
				}
				if (value.length >= 7) {
					formattedValue += '-' + value.substring(7, 9);
				}
				if (value.length >= 9) {
					formattedValue += '-' + value.substring(9, 11);
				}
			}
			
			this.value = formattedValue;
		});
		
		input.addEventListener('keydown', function(e) {
			// При удалении, если осталось только +7, очищаем поле
			if (e.key === 'Backspace' && this.value.length <= 4) {
				this.value = '';
				e.preventDefault();
			}
		});
		
		input.addEventListener('focus', function() {
			if (this.value === '') {
				this.value = '+7';
			}
		});
		
		input.addEventListener('blur', function() {
			// Если поле содержит только +7, очищаем
			if (this.value === '+7' || this.value === '+7 (') {
				this.value = '';
			}
		});
	});

	// Callback form submission
	const callbackForm = document.querySelector('.js-callback-form');
	if (callbackForm && typeof zamok01_ajax !== 'undefined') {
		callbackForm.addEventListener('submit', function(e) {
			e.preventDefault();
			
			const submitButton = this.querySelector('.js-callback-submit');
			const formData = new FormData(this);
			
			// Добавляем action и nonce
			formData.append('action', 'send_callback');
			formData.append('nonce', zamok01_ajax.nonce);
			
			// Блокируем кнопку отправки
			if (submitButton) {
				submitButton.disabled = true;
				const originalText = submitButton.querySelector('.button-title').textContent;
				submitButton.querySelector('.button-title').textContent = 'Отправка...';
			}
			
			fetch(zamok01_ajax.ajax_url, {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Закрываем текущее окно
					document.body.classList.remove('popup-open');
					document.querySelector('#popup-callback').classList.remove('active');
					
					// Очищаем форму
					callbackForm.reset();
					
					// Открываем окно успеха
					setTimeout(function() {
						document.body.classList.add('popup-open');
						document.querySelector('#popup-callback-success').classList.add('active');
					}, 300);
				} else {
					alert(data.data && data.data.message ? data.data.message : 'Произошла ошибка при отправке формы. Попробуйте еще раз.');
				}
			})
			.catch(error => {
				console.error('Ошибка отправки формы:', error);
				alert('Произошла ошибка при отправке формы. Попробуйте еще раз.');
			})
			.finally(() => {
				// Разблокируем кнопку отправки
				if (submitButton) {
					submitButton.disabled = false;
					submitButton.querySelector('.button-title').textContent = 'Отправить';
				}
			});
		});
	}

	// Posts page AJAX - вкладки категорий и кнопка "Развернуть еще"
	const postsTabs = document.querySelectorAll('.js-posts-tab');
	const postsContainer = document.querySelector('.js-posts-container');
	const postsLoadMoreBtn = document.querySelector('.js-posts-load-more');
	
	if (postsContainer && typeof zamok01_ajax !== 'undefined') {
		// Обработка вкладок категорий
		if (postsTabs.length > 0) {
			postsTabs.forEach(function(tab) {
				tab.addEventListener('click', function(e) {
					e.preventDefault();
					
					// Убираем активный класс со всех табов
					postsTabs.forEach(function(t) {
						t.classList.remove('active');
					});
					
					// Добавляем активный класс к текущему табу
					this.classList.add('active');
					
					// Получаем ID категории
					const categoryId = this.getAttribute('data-category-id');
					const categorySlug = this.getAttribute('data-category-slug');
					
					// Показываем индикатор загрузки
					const itemsWrap = postsContainer.querySelector('.items-wrap');
					if (itemsWrap) {
						itemsWrap.style.opacity = '0.5';
						itemsWrap.style.pointerEvents = 'none';
					}
					
					// Скрываем кнопку "Развернуть еще" во время загрузки
					if (postsLoadMoreBtn) {
						postsLoadMoreBtn.style.display = 'none';
					}
					
					// AJAX запрос
					const formData = new FormData();
					formData.append('action', 'load_posts');
					formData.append('category_id', categoryId);
					formData.append('page', 1);
					formData.append('append', false);
					formData.append('nonce', zamok01_ajax.nonce);
					
					fetch(zamok01_ajax.ajax_url, {
						method: 'POST',
						body: formData
					})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							// Обновляем контент постов
							if (itemsWrap && data.data.posts) {
								itemsWrap.innerHTML = data.data.posts;
							}
							
							// Обновляем кнопку "Развернуть еще"
							if (postsLoadMoreBtn) {
								if (data.data.has_more) {
									postsLoadMoreBtn.style.display = '';
									postsLoadMoreBtn.setAttribute('data-page', '1');
									postsLoadMoreBtn.setAttribute('data-total-pages', data.data.max_pages);
								} else {
									postsLoadMoreBtn.style.display = 'none';
								}
							}
							
							// Обновляем URL без перезагрузки страницы
							const baseUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;
							const newUrl = categoryId == 0 ? baseUrl : baseUrl + '?category=' + categorySlug;
							window.history.pushState({ category: categoryId }, '', newUrl);
							
							// Прокрутка вверх контейнера
							postsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
						}
					})
					.catch(error => {
						console.error('Ошибка загрузки постов:', error);
					})
					.finally(() => {
						// Убираем индикатор загрузки
						if (itemsWrap) {
							itemsWrap.style.opacity = '1';
							itemsWrap.style.pointerEvents = 'auto';
						}
					});
				});
			});
		}
		
		// Обработка кнопки "Развернуть еще"
		if (postsLoadMoreBtn) {
			postsLoadMoreBtn.addEventListener('click', function(e) {
				e.preventDefault();
				
				const activeTab = document.querySelector('.js-posts-tab.active');
				if (!activeTab) return;
				
				const categoryId = activeTab.getAttribute('data-category-id');
				const currentPage = parseInt(this.getAttribute('data-page')) || 1;
				const nextPage = currentPage + 1;
				const totalPages = parseInt(this.getAttribute('data-total-pages')) || 1;
				
				if (nextPage > totalPages) {
					this.style.display = 'none';
					return;
				}
				
				const itemsWrap = postsContainer.querySelector('.items-wrap');
				if (itemsWrap) {
					itemsWrap.style.opacity = '0.5';
					itemsWrap.style.pointerEvents = 'none';
				}
				
				// Блокируем кнопку
				this.style.pointerEvents = 'none';
				this.querySelector('.button-title').textContent = 'Загрузка...';
				
				const formData = new FormData();
				formData.append('action', 'load_posts');
				formData.append('category_id', categoryId);
				formData.append('page', nextPage);
				formData.append('append', true);
				formData.append('nonce', zamok01_ajax.nonce);
				
				fetch(zamok01_ajax.ajax_url, {
					method: 'POST',
					body: formData
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						// Добавляем новые посты к существующим
						if (itemsWrap && data.data.posts) {
							itemsWrap.insertAdjacentHTML('beforeend', data.data.posts);
						}
						
						// Обновляем кнопку "Развернуть еще"
						if (data.data.has_more) {
							this.setAttribute('data-page', nextPage);
							this.querySelector('.button-title').textContent = 'Развернуть еще→';
							this.style.display = '';
						} else {
							this.style.display = 'none';
						}
					}
				})
				.catch(error => {
					console.error('Ошибка загрузки постов:', error);
					this.querySelector('.button-title').textContent = 'Развернуть еще→';
				})
				.finally(() => {
					// Убираем индикатор загрузки
					if (itemsWrap) {
						itemsWrap.style.opacity = '1';
						itemsWrap.style.pointerEvents = 'auto';
					}
					this.style.pointerEvents = 'auto';
				});
			});
		}
	}

})