@php
    $apiOperatorUi = __('app.api_operator.ui');
@endphp
<div
    id="api-operator-chat-root"
    data-api-operator-widget
    data-guided-agent="1"
    wire:ignore
    data-status-url="{{ route('api-operator.status') }}"
    data-chat-url="{{ route('api-operator.chat') }}"
    data-greeting='@json(__('app.api_operator.greeting'))'
    data-unavailable='@json(__('app.api_operator.unavailable'))'
    data-confirm-hint='@json(__('app.api_operator.confirm_hint'))'
    data-i18n='@json($apiOperatorUi)'
    data-placeholder='@json(__('app.api_operator.placeholder'))'
    data-central-domain="{{ config('app.central_domain') }}"
    style="position:fixed;bottom:24px;right:24px;z-index:2147483646;font-family:system-ui,sans-serif;"
    dir="ltr"
>
    <div
        data-api-operator-panel
        style="display:none;flex-direction:column;width:min(100vw - 2rem, 24rem);height:34rem;margin-bottom:1rem;background:#fff;border-radius:1rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);border:1px solid #e5e7eb;overflow:hidden;"
    >
        <div style="flex-shrink:0;display:flex;align-items:center;justify-content:space-between;padding:0.75rem 1rem;background:#4f46e5;color:#fff;">
            <div>
                <p style="margin:0;font-weight:600;font-size:0.875rem;">{{ __('app.api_operator.title') }}</p>
                <p style="margin:0.15rem 0 0;font-size:0.7rem;color:#c7d2fe;">{{ __('app.api_operator.subtitle') }}</p>
                <p data-api-operator-status style="margin:0.25rem 0 0;font-size:0.7rem;color:#a5b4fc;">…</p>
            </div>
            <button type="button" data-api-operator-close style="background:transparent;border:none;color:#fff;font-size:1.25rem;cursor:pointer;line-height:1;" aria-label="Close">&times;</button>
        </div>

        <div data-api-operator-messages style="flex:1 1 auto;min-height:0;overflow-y:auto;padding:1rem;background:#f9fafb;">
            <div data-initial-agent-message style="display:flex;justify-content:flex-start;margin-bottom:0.75rem;">
                <div style="max-width:90%;padding:0.5rem 0.75rem;border-radius:1rem;font-size:0.875rem;white-space:pre-wrap;background:#fff;color:#1f2937;border:1px solid #e5e7eb;">{{ __('app.api_operator.greeting') }}</div>
            </div>
        </div>

        <div
            data-api-operator-quick-actions
            style="flex-shrink:0;display:flex;flex-wrap:wrap;gap:0.375rem;padding:0.5rem 0.75rem;border-top:1px solid #e5e7eb;border-bottom:1px solid #e5e7eb;background:#f8fafc;min-height:2.75rem;"
        ></div>

        <form data-api-operator-form style="flex-shrink:0;padding:0.75rem;border-top:1px solid #e5e7eb;background:#fff;margin:0;">
            <div style="display:flex;gap:0.5rem;">
                <input
                    data-api-operator-input
                    type="text"
                    placeholder="{{ __('app.api_operator.placeholder') }}"
                    style="flex:1;border:1px solid #d1d5db;border-radius:0.75rem;padding:0.5rem 0.75rem;font-size:0.875rem;"
                    autocomplete="off"
                />
                <button
                    data-api-operator-send
                    type="submit"
                    style="padding:0.5rem 1rem;background:#4f46e5;color:#fff;border:none;border-radius:0.75rem;font-size:0.875rem;font-weight:600;cursor:pointer;"
                >{{ __('app.api_operator.send') }}</button>
            </div>
            <p style="margin:0.5rem 0 0;font-size:11px;color:#6b7280;">{{ __('app.api_operator.confirm_hint') }}</p>
        </form>
    </div>

    <button
        type="button"
        data-api-operator-fab
        aria-label="{{ __('app.api_operator.title') }}"
        aria-expanded="false"
        style="width:56px;height:56px;border-radius:9999px;background:#4f46e5;color:#fff;border:4px solid #fff;cursor:pointer;box-shadow:0 10px 15px -3px rgba(0,0,0,.2);font-size:1.5rem;line-height:1;display:flex;align-items:center;justify-content:center;"
    >&#128172;</button>
</div>
