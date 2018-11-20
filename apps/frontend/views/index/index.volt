{#Frontend module - class index<br/>
Test translation {{ trans._("validation.accepted", ['attribute': 'field']) }}<br/>
{{ partial('test') }}#}



<section class="error-content error-404 js-error-container">
    <section class="error-details">
        <section class="error-message text-center">
            <h1 class="page-code">{{ trans._('main.welcome_to_phalcon_scelet') }}</h1>
            <h2 class="error-description">Frontend module - class index</h2>
            {% if config.lang_active is not 'en' %}
            <a href="/">EN</a> |
            {% endif %}
            {% if config.lang_active is not 'ua' %}
            <a href="/ua">UA</a> |
            {% endif %}
            {% if config.lang_active is not 'ru' %}
            <a href="/ru">RU</a>
            {% endif %}
            <br>
            <a href="{{ url(['for': 'frontend.page']) }}">{{ trans._('main.other_page') }}</a><br/>
            <a href="{{ url(['for': 'backend.index']) }}">{{ trans._('main.admin_module') }}</a>
        </section>
    </section>
</section>