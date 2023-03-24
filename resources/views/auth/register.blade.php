<x-guest-layout>
    @if(session()->has('error'))
        <div id="alert-2" class="flex mr-6 ml-6 p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            <div class="ml-3 text-sm font-medium">
                {{ session()->get('error') }}
            </div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
                <span class="sr-only">Закрыть</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Имя (на английском)')" />
            <x-text-input id="name" class="block mt-1 w-full border-2" type="text" name="name" :value="old('name')" placeholder="Imya" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <!-- Surname -->
        <div>
            <x-input-label for="surname" :value="__('Фамилия (на английском)')" />
            <x-text-input id="surname" class="block mt-1 w-full border-2" type="text" name="surname" :value="old('surname')" placeholder="Familiya" required autofocus autocomplete="surname" />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Номер телефона')" />
            <x-text-input id="login" class="block phone mt-1 w-full border-2" type="text" name="login" placeholder="+7 701 775 7272" :value="old('login')" required autocomplete="login" />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city" :value="__('Город (на английском)')" />
            <x-text-input id="city" class="block mt-1 w-full border-2" type="text" name="city" :value="old('city')" placeholder="Gorod" required autocomplete="city" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- Code -->
        <div class="mt-4">
            <x-input-label for="code" :value="__('Код')" />
            <x-text-input id="code" class="block mt-1 w-full border-2 border-sky-400" type="text" name="code" :value="old('code')" placeholder="Код" required autocomplete="code" />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <a href="https://api.whatsapp.com/send?phone={{$config->whats_app}}&text=Здравствуйте! Дайте мне, пожалуйста, код для регистрации" class="w-full mx-auto">
                У Вас нет кода?
            </a>
        </div>
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full border-2"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Подтвердите пароль')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-2"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="mt-4">
            <input type="checkbox" name="checkbox" value="true" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" required />
            <label for="checkbox" class="ml-2 text-sm text-gray-900">Принимаю условия <a data-modal-target="staticModal" data-modal-toggle="staticModal" class="font-medium cursor-pointer">Соглашения при регистрации</a></label>


            <!-- Main modal -->
            <div id="staticModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                <div class="relative w-full h-full max-w-2xl">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <!-- Modal header -->
                        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Условия соглашения
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="staticModal">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6 space-y-2">
                            <p class="text-base leading-relaxed text-gray-500">
                                <b>Нет минимального веса и суммы заказа</b>
                                <ul>
                                    <li>✔️ Склад в г.Иу</li>
                                        <ul><b>✔️ Автодоставка:</b>
                                        <li>- 5 $ до Алматы</li>
                                        <li>- 5.2$ Регионы</li>
                                        <li>- 15-25 дней, не включая праздники или комиссии на таможне</li>
                                        </ul>
                                    <li>✔️ отчетность по трекам</li>
                                    <li>✔️ сайт для отслеживания товара</li>
                                </ul>
                                <p>◾️ Возврат денег за неполученный товар осуществляется клиенту только в случае утери на одном из складов или при досмотре на таможне.</p>
                            <p>🆘 Компания не несет ответственности за возможные изменения в сроках доставки по причинам, признанным форс-мажором на государственном и мировом уровне( катастрофы, стихийные бедствия, пандемии, военные действия, и т.д.)
                            </p><p>❗️ Товар уже поступивший на китайский склад, необходимо будет ожидать до получения независимо от сроков!
                            </p>

                                <p>Хрупкий товар Наша работа заключается в доставке ваших посылок в том виде, в каком они поступили на китайский склад. Если вы получили товар с недостачей или несоответствием- все вопросы по внутреннему вложению посылок к продавцу. При поступлений посылки, если посылка недостаточно упаковано, китайский склад сделает деревянную обрешетку автоматически(без спроса клиента) за дополнительную оплату ( начинается с 15$+) За сохранность хрупких и ломких предметов ответственности не несем! При покупке хрупкого товара попросите продавца упаковать его с защитой( обрешетка, защита края, пузырчатая пленка)</
                            <p><b> Отправка из Алматы по регионам</b></p>

                                <ul><b>Отправка по городам с Алматы:</b>
                                    <li>✔️Отгрузка на Камаз( или частный автобус на барахолке) и рейсовый автобус(при наличии рейса в ваш город)- *доплата 500тг грузчику</li>
                                    <li>- +за место при получении оплачиваете сами</li>
                                    <li>- Заявки на отправку принимаются по полной оплате долга</li>
                                    <li>- Выдача или самовывоз для Алматы 10:00-16:00</li>
                                    <li>- Западное направление (Актау, Атырау, Уральск, Актобе, Жанаозен) возможна отправка ж/д или авиа.</li>
                                    <li>- В день отправки вам скинут квитанцию или визитку с данными фирмы грузоперевозок.</li>
                                </ul>
                            </p>

                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="staticModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Уже зарегистрированы?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Зарегистрироваться') }}
            </x-primary-button>
        </div>


    </form>

        <script src="{{ asset('/js/flowbite.js') }}"></script>
</x-guest-layout>
