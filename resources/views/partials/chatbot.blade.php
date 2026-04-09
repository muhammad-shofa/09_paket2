<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
    <!-- Chat Window -->
    <div id="chatbot-window" class="hidden w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden mb-4 transition-all transform origin-bottom-right">
        <!-- Header -->
        <div class="bg-indigo-600 p-4 text-white flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="ph-bold ph-robot text-2xl"></i>
                <div>
                    <h3 class="font-bold text-sm">Parkir Assistant (AI)</h3>
                    <p class="text-xs text-indigo-200">Selalu siap membantu</p>
                </div>
            </div>
            <button id="chatbot-close" class="text-white hover:text-indigo-200 focus:outline-none">
                <i class="ph-bold ph-x text-lg"></i>
            </button>
        </div>
        
        <!-- Messages -->
        <div id="chatbot-messages" class="h-80 p-4 overflow-y-auto bg-slate-50 flex flex-col gap-3 space-y-2">
            <!-- Bot Bubble -->
            <div class="flex items-start gap-2 max-w-[85%]">
                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                    <i class="ph-bold ph-robot text-indigo-600"></i>
                </div>
                <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-sm text-slate-700">
                    Halo! Saya asisten AI Parkir Sek. Ada yang bisa saya bantu terkait data operasional hari ini?
                </div>
            </div>
        </div>
        
        <!-- Input -->
        <div class="p-3 bg-white border-t border-slate-100">
            <form id="chatbot-form" class="flex items-center gap-2">
                <input type="text" id="chatbot-input" autocomplete="off" placeholder="Tanya estimasi harga, kapasitas..." class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                <button type="submit" id="chatbot-send" class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center hover:bg-indigo-700 transition-colors focus:outline-none flex-shrink-0">
                    <i class="ph-bold ph-paper-plane-right"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="chatbot-toggle" class="w-14 h-14 bg-indigo-600 text-white rounded-full shadow-lg hover:shadow-xl hover:bg-indigo-700 hover:scale-105 transition-all flex items-center justify-center focus:outline-none">
        <i class="ph-bold ph-chat-teardrop-dots text-3xl"></i>
    </button>
</div>

@push('scripts')
<script>
    // System context variable
    // Load Context on page load (optional)
    // Removed initial fetch as it causes redundancy with submission sync fetch

    const chatWindow = document.getElementById('chatbot-window');
    const chatToggle = document.getElementById('chatbot-toggle');
    const chatClose = document.getElementById('chatbot-close');
    const chatForm = document.getElementById('chatbot-form');
    const chatInput = document.getElementById('chatbot-input');
    const chatMessages = document.getElementById('chatbot-messages');
    const chatSendBtn = document.getElementById('chatbot-send');

    // Toggle Chat
    chatToggle.addEventListener('click', () => {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            chatInput.focus();
        }
    });

    chatClose.addEventListener('click', () => {
        chatWindow.classList.add('hidden');
    });

    // Append Message to UI
    function appendMessage(text, isUser = false) {
        const div = document.createElement('div');
        div.className = isUser 
            ? "flex items-end justify-end gap-2 max-w-[85%] self-end"
            : "flex items-start gap-2 max-w-[85%] self-start";

        const bubbleClass = isUser
            ? "bg-indigo-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm text-sm"
            : "bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-sm text-slate-700";

        let avatar = '';
        if (!isUser) {
            avatar = `<div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                        <i class="ph-bold ph-robot text-indigo-600"></i>
                      </div>`;
        }

        // basic formatting
        let formattedText = text.replace(/\n/g, '<br>');

        div.innerHTML = `
            ${!isUser ? avatar : ''}
            <div class="${bubbleClass}">${formattedText}</div>
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Handle Submit
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if (!msg) return;

        appendMessage(msg, true);
        chatInput.value = '';
        chatInput.disabled = true;
        chatSendBtn.disabled = true;
        chatSendBtn.innerHTML = '<i class="ph-bold ph-spinner animate-spin"></i>';

        try {
            // Selalu ambil konteks terbaru saat submit dan pass pesan user agar server bisa mengekstrak nomor tiket!
            const contextRes = await fetch("{{ route('chatbot.context') }}?msg=" + encodeURIComponent(msg));
            const contextData = await contextRes.json();
            const currentContext = contextData.context;

            // Build the prompt with context
            const prompt = `DATA DASHBOARD SAAT INI:\n${currentContext}\n\nINSTRUKSI UNTUKMU:\n1. Kamu adalah "Parkir Sek AI".\n2. Jika user hanya menyapa (misal: "halo"), balaslah sapaan tersebut dengan ramah dan tanyakan apa yang bisa dibantu. JANGAN membeberkan data jika tidak ditanya!\n3. Jika user menanyakan status atau informasi TIKET, segera periksa bagian "HASIL PENELUSURAN NO TIKET" di atas dan jawablah dengan tagihan, durasi, dan rincian kendaraan tersebut.\n4. Berikan jawaban yang relevan dan efisien.\n\nPertanyaan User: ${msg}`;
            
            // Call Puter.js
            const response = await puter.ai.chat(prompt);
            
            // Extract message
            let botText = typeof response === 'string' ? response : (response.message?.content || response.text || "Terjadi masalah format.");
            appendMessage(botText);

        } catch (error) {
            appendMessage("Maaf, terjadi kesalahan atau koneksi ke AI gagal.");
            console.error(error);
        } finally {
            chatInput.disabled = false;
            chatSendBtn.disabled = false;
            chatSendBtn.innerHTML = '<i class="ph-bold ph-paper-plane-right"></i>';
            chatInput.focus();
        }
    });
</script>
@endpush
