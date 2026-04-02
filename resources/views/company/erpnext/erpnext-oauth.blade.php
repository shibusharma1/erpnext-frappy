<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connect to ERPNext</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .logo svg {
            width: 40px;
            height: 40px;
            fill: white;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .connect-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .connect-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .connect-btn:active {
            transform: translateY(0);
        }

        .connect-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .status {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }

        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status.info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
            vertical-align: middle;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .features {
            text-align: left;
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .features h3 {
            margin-top: 0;
            color: #333;
        }

        .features ul {
            margin: 0;
            padding-left: 20px;
        }

        .features li {
            margin: 10px 0;
            color: #666;
        }

        .disconnect-btn {
            background: #dc3545;
            margin-left: 10px;
        }

        .disconnect-btn:hover {
            background: #c82333;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .debug-info {
            margin-top: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            font-size: 12px;
            text-align: left;
            display: none;
            max-height: 300px;
            overflow-y: auto;
        }

        .debug-info pre {
            margin: 5px 0;
            overflow-x: auto;
            font-size: 11px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .toggle-debug {
            margin-top: 10px;
            font-size: 12px;
            color: #667eea;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
            </svg>
        </div>

        <h1>Connect to ERPNext</h1>
        <p>Connect DeltaSalesApp with ERPNext to sync data, manage items, and automate workflows.</p>


        <div id="status" class="status"></div>

        <div class="button-group">
            <button id="connectBtn" class="connect-btn">
                Connect to ERPNext
            </button>

            @if (Session::has('erpnext_access_token'))
                <button id="disconnectBtn" class="connect-btn disconnect-btn">
                    Disconnect
                </button>
                <button id="connectBtn" class="connect-btn">
                    <a href="{{ route('customers.index') }}" style="text-decoration: none;color:white;">View Customers</a>
                </button>
            @endif



        </div>

        <div class="toggle-debug" onclick="$('#debug-info').toggle();">
            Show/Hide Debug Info
        </div>
        <div id="debug-info" class="debug-info">
            <strong>Debug Information:</strong>
            <pre id="debug-content">Loading...</pre>
        </div>
    </div>

    <script>
        var erpnextConfig = {
            domain: @json($domain),
            callbackUrl: @json($redirectUri),
            authUrl: @json($authUrl),
            hasToken: @json(Session::has('erpnext_access_token'))
        };

        $(document).ready(function() {
            var popup = null;
            var pollInterval = null;

            var domain = erpnextConfig.domain;
            var callbackUrl = erpnextConfig.callbackUrl;
            var authUrl = erpnextConfig.authUrl;

            function debugLog(message, data) {
                console.log('[ERPNext OAuth]', message, data || '');
                var debugContent = $('#debug-content');
                var timestamp = new Date().toLocaleTimeString();
                var logEntry = '[' + timestamp + '] ' + message;
                if (data) {
                    logEntry += '\n' + JSON.stringify(data, null, 2);
                }
                var currentText = debugContent.text();
                debugContent.text(currentText + '\n' + logEntry);
                debugContent.scrollTop(debugContent[0].scrollHeight);
            }

            debugLog('Initialized', {
                domain: domain,
                callbackUrl: callbackUrl,
                authUrl: authUrl,
                hasToken: erpnextConfig.hasToken
            });

            function showStatus(message, type) {
                var statusDiv = $('#status');
                statusDiv.text(message);
                statusDiv.removeClass('success error info').addClass(type);
                statusDiv.show();

                setTimeout(function() {
                    statusDiv.fadeOut();
                }, 5000);
            }

            function cleanup() {
                debugLog('Cleaning up');
                if (pollInterval) {
                    clearInterval(pollInterval);
                    pollInterval = null;
                }
                if (popup && !popup.closed) {
                    popup.close();
                    popup = null;
                }
            }

            function handleCallback(url) {
                debugLog('Handling callback', {
                    url: url
                });

                try {
                    var urlObj = new URL(url);
                    var code = urlObj.searchParams.get('code');
                    var state = urlObj.searchParams.get('state');
                    var error = urlObj.searchParams.get('error');

                    if (error) {
                        var errorDesc = urlObj.searchParams.get('error_description') || 'Unknown error';
                        showStatus('Error: ' + error + ' - ' + errorDesc, 'error');
                        debugLog('OAuth error', {
                            error: error,
                            description: errorDesc
                        });
                        cleanup();
                        return;
                    }

                    if (code) {
                        debugLog('Authorization code received');
                        showStatus('Authorization successful! Exchanging code for token...', 'info');

                        $.ajax({
                            url: callbackUrl,
                            type: 'POST',
                            contentType: 'application/json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: JSON.stringify({
                                code: code,
                                state: state
                            }),
                            success: function(response) {
                                debugLog('Token exchange response', response);
                                if (response.success) {
                                    showStatus('Successfully connected to ERPNext!', 'success');
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 1500);
                                } else {
                                    showStatus('Connection failed: ' + (response.error || response
                                        .message || 'Unknown error'), 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                debugLog('Token exchange error', {
                                    status: status,
                                    error: error,
                                    response: xhr.responseText
                                });
                                showStatus('Connection failed: ' + error, 'error');
                            },
                            complete: function() {
                                cleanup();
                            }
                        });
                    } else {
                        showStatus('Authorization failed: No code received', 'error');
                        debugLog('No code in callback URL');
                        cleanup();
                    }
                } catch (e) {
                    debugLog('Error handling callback', {
                        error: e.message
                    });
                    showStatus('Error processing callback: ' + e.message, 'error');
                    cleanup();
                }
            }

            // Start OAuth flow
            function startOAuth() {
                debugLog('Starting OAuth flow');

                if (popup && !popup.closed) {
                    popup.close();
                }

                var width = 800;
                var height = 650;
                var left = (screen.width - width) / 2;
                var top = (screen.height - height) / 2;
                var popupParams = 'location=1,width=' + width + ',height=' + height + ',left=' + left + ',top=' +
                    top;

                debugLog('Opening popup with URL', authUrl);
                popup = window.open(authUrl, 'ERPNextConnect', popupParams);

                if (!popup || popup.closed) {
                    showStatus('Popup blocked! Please allow popups for this site and try again.', 'error');
                    debugLog('Popup blocked or closed');
                    return false;
                }

                debugLog('Popup opened successfully');

                setTimeout(function() {
                    if (popup && popup.closed) {
                        showStatus('Popup was closed. Please try again.', 'error');
                        debugLog('Popup closed immediately');
                        cleanup();
                    }
                }, 1000);

                pollInterval = setInterval(function() {
                    try {
                        if (popup && !popup.closed) {
                            var popupUrl = popup.location.href;
                            if (popupUrl && popupUrl !== 'about:blank') {
                                debugLog('Polling popup URL', popupUrl);

                                if (popupUrl.indexOf(callbackUrl) !== -1) {
                                    debugLog('Redirect detected to callback URL');
                                    handleCallback(popupUrl);
                                }
                            }
                        } else if (popup && popup.closed) {
                            debugLog('Popup closed by user');
                            cleanup();
                        }
                    } catch (e) {
                        if (e.name !== 'SecurityError' && e.name !== 'NS_ERROR_FAILURE') {
                            debugLog('Polling error', {
                                name: e.name,
                                message: e.message
                            });
                        }
                    }
                }, 500);

                return true;
            }

            $('#connectBtn').on('click', function(e) {
                e.preventDefault();

                var $btn = $(this);
                var originalText = $btn.html();

                $btn.html('Connecting... <span class="loading"></span>');
                $btn.prop('disabled', true);

                try {
                    var success = startOAuth();
                    if (!success) {
                        $btn.html(originalText);
                        $btn.prop('disabled', false);
                    } else {
                        setTimeout(function() {
                            if ($btn.prop('disabled')) {
                                $btn.html(originalText);
                                $btn.prop('disabled', false);
                                showStatus('Connection timeout. Please try again.', 'error');
                                cleanup();
                            }
                        }, 30000);
                    }
                } catch (error) {
                    debugLog('Start OAuth error', {
                        error: error.message
                    });
                    showStatus('Failed to start connection: ' + error.message, 'error');
                    $btn.html(originalText);
                    $btn.prop('disabled', false);
                }
            });

            $('#disconnectBtn').on('click', function(e) {
                e.preventDefault();

                if (confirm('Are you sure you want to disconnect from ERPNext?')) {
                    var disconnectUrl = '/' + domain + '/admin/erpnext/disconnect';

                    debugLog('Disconnecting', {
                        url: disconnectUrl
                    });

                    $.ajax({
                        url: disconnectUrl,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            showStatus('Disconnected successfully', 'success');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            debugLog('Disconnect error', {
                                status: status,
                                error: error
                            });
                            showStatus('Failed to disconnect: ' + error, 'error');
                        }
                    });
                }
            });

            $(window).on('beforeunload', function() {
                if (popup && !popup.closed) {
                    popup.close();
                }
                if (pollInterval) {
                    clearInterval(pollInterval);
                }
            });
        });
    </script>
</body>

</html>
