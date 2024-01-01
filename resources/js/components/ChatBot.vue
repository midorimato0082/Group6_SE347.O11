<template>
    <div class="chatbox-wrapper">
        <div @click="toggleChatbox" class="chatbox-toggle">
            <i class='bx bx-message-dots'></i>
        </div>
        <div class="chatbox-message-wrapper" :class="{show: chatboxToggle}">
            <div class="chatbox-message-header">
                <div class="chatbox-message-profile">
                    <img src="https://cdn-icons-png.flaticon.com/512/8649/8649595.png" alt="" class="chatbox-message-image">
                    <div>
                        <h4 class="chatbox-message-name">Trợ lý tư vấn du lịch</h4>
                        <p class="chatbox-message-status">online</p>
                    </div>
                </div>
            </div>
            <div class="chatbox-message-content">
                <h4 v-if="chatboxContent.length === 0" class="chatbox-message-no-message">You don't have message yet!</h4>
                <div style="display: flex" v-for="message in chatboxContent" v-html="message"></div>
                <TypingComponent v-if="isBotChatting"></TypingComponent>
            </div>
            <div class="chatbox-message-bottom">
                <form action="#" class="chatbox-message-form" v-on:submit="chatboxFormSubmit">
                    <textarea @input="inputTyping" v-model="chatboxInput" :rows="inputRow" placeholder="Type message..." class="chatbox-message-input"></textarea>
                    <button type="submit" class="chatbox-message-submit"><i class='bx bx-send' ></i></button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import TypingComponent from "@/components/TypingComponent.vue";

const chatboxToggle = ref(false)
const chatboxInput = ref('')
const chatboxContent = ref([])
const inputRow = ref(1)
const isBotChatting = ref(false)

const toggleChatbox = () => {
    chatboxToggle.value = !chatboxToggle.value
}

const inputTyping = () => {
    let line = chatboxInput.value.split('\n').length

    if(inputRow.value < 6 || line < 6) {
        inputRow.value = line
    }
}

const apiKey = import.meta.env.VITE_PUSHER_OPENAI_API_KEY
const apiUrl = 'https://api.openai.com/v1/chat/completions';

const chatboxFormSubmit = async (e) => {
    e.preventDefault()

    if(isValid(chatboxInput.value)) {
        writeMessage()
        isBotChatting.value = true;

        const data = {
            model: 'gpt-3.5-turbo',
            messages: [
                {
                    role: 'system',
                    content: 'Bạn là ai?',
                },
                {
                    role: 'user',
                    content: chatboxInput.value,
                },
            ],
        };
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${apiKey}`,
            },
            body: JSON.stringify(data),
        })
            .then(response => response.json())
            .then(result => {
                autoReply(result.choices[0].message.content)
            })
            .catch(error => console.error('Lỗi:', error))
            .finally(() => {
                isBotChatting.value = false;
            })

        chatboxInput.value = ''
    }
}
const addZero = (num) => {
    return num < 10 ? '0'+num : num
}

const writeMessage = () => {
    const today = new Date()
    let message = `
		<div class="chatbox-message-item sent">
			<span class="chatbox-message-item-text">
				${chatboxInput.value.trim().replace(/\n/g, '<br>\n')}
			</span>
			<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		</div>
	`
    chatboxContent.value.push(message)
    scrollBottom()
}
const autoReply = (resultMessage) => {
    const today = new Date()
    let message = `
		<div class="chatbox-message-item received">
			<span class="chatbox-message-item-text">
				${resultMessage}
			</span>
			<span class="chatbox-message-item-time">${addZero(today.getHours())}:${addZero(today.getMinutes())}</span>
		</div>
	`
    chatboxContent.value.push(message)
    scrollBottom()
}

const scrollBottom = () => {
    const content = document.querySelector('.chatbox-message-content')
    setTimeout(() => {
        content.scrollTo(0, content.scrollHeight)
    }, 100)
}

const isValid = (value) => {
    let text = value.replace(/\n/g, '')
    text = text.replace(/\s/g, '')

    return text.length > 0
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

/* Box sizing rules */
*,
*::before,
*::after {
    box-sizing: border-box;
}

/* Remove default margin */
body,
h1,
h2,
h3,
h4,
p,
figure,
blockquote,
dl,
dd {
    margin: 0;
}

/* Remove list styles on ul, ol elements with a list role, which suggests default styling will be removed */
ul[role='list'],
ol[role='list'] {
    list-style: none;
}

/* Set core root defaults */
html:focus-within {
    scroll-behavior: smooth;
}

/* A elements that don't have a class get default styles */
a:not([class]) {
    text-decoration-skip-ink: auto;
}

/* Make images easier to work with */
img,
picture {
    max-width: 100%;
    display: block;
}

/* Inherit fonts for inputs and buttons */
input,
button,
textarea,
select {
    font: inherit;
}

/* Remove all animations, transitions and smooth scroll for people that prefer not to see them */
@media (prefers-reduced-motion: reduce) {
    html:focus-within {
        scroll-behavior: auto;
    }

    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}

/* GLOBAL STYLES */
:root {
    --blue: #335DFF;
    --grey: #F5F5F5;
    --grey-d-1: #EEE;
    --grey-d-2: #DDD;
    --grey-d-3: #888;
    --white: #FFF;
    --dark: #222;
}
/* GLOBAL STYLES */







/* CHATBOX */
.chatbox-wrapper {
    position: fixed;
    bottom: 1rem;
    right: 1rem;
    width: 4rem;
    height: 4rem;
}
.chatbox-toggle {
    width: 100%;
    height: 100%;
    background: var(--blue);
    color: var(--white);
    font-size: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    cursor: pointer;
    transition: .2s;
}
.chatbox-toggle:active {
    transform: scale(.9);
}
.chatbox-message-wrapper {
    z-index: 1000;
    position: absolute;
    bottom: calc(100% + 1rem);
    right: 0;
    width: 420px;
    border-radius: .5rem;
    overflow: hidden;
    box-shadow: .5rem .5rem 2rem rgba(0, 0, 0, .1);
    transform: scale(0);
    transform-origin: bottom right;
    transition: .2s;
}
.chatbox-message-wrapper.show {
    transform: scale(1);
}
.chatbox-message-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--white);
    padding: .75rem 1.5rem;
}
.chatbox-message-profile {
    display: flex;
    align-items: center;
    grid-gap: .5rem;
}
.chatbox-message-image {
    width: 3rem;
    height: 3rem;
    object-fit: cover;
    border-radius: 50%;
}
.chatbox-message-name {
    font-size: 1.125rem;
    font-weight: 600;
}
.chatbox-message-status {
    font-size: .875rem;
    color: var(--grey-d-3);
}
.chatbox-message-dropdown {
    position: relative;
}
.chatbox-message-dropdown-toggle {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 2.5rem;
    height: 2.5rem;
    font-size: 1.25rem;
    cursor: pointer;
    border-radius: 50%;
}
.chatbox-message-dropdown-toggle:hover {
    background: var(--grey);
}
.chatbox-message-content {
    background: var(--grey);
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    grid-row-gap: 1rem;
    max-height: 300px;
    overflow-y: auto;
}
.chatbox-message-item {
    width: 90%;
    padding: 1rem;
}
.chatbox-message-item.sent {
    margin-left:auto;
    background: var(--blue);
    color: var(--white);
    border-radius: .75rem 0 .75rem .75rem;
}
.chatbox-message-item.received {
    background: var(--white);
    border-radius: 0 .75rem .75rem .75rem;
    box-shadow: .25rem .25rem 1.5rem rgba(0, 0, 0, .05);
}
.chatbox-message-item-time {
    float: right;
    font-size: .75rem;
    margin-top: .5rem;
    display: inline-block;
}
.chatbox-message-bottom {
    background: var(--white);
    padding: .75rem 1.5rem;
}
.chatbox-message-form {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--grey);
    border-radius: .5rem;
    padding: .5rem 1.25rem;
}
.chatbox-message-input {
    background: transparent;
    outline: none;
    border: none;
    resize: none;
    scrollbar-width: none;
}
.chatbox-message-input::-webkit-scrollbar {
    display: none;
}
.chatbox-message-submit {
    font-size: 1.25rem;
    color: var(--blue);
    background: transparent;
    border: none;
    outline: none;
    cursor: pointer;
}
.chatbox-message-no-message {
    font-size: 1rem;
    font-weight: 600;
    text-align: center;
}
/* CHATBOX */







/* BREAKPOINTS */
@media screen and (max-width: 576px) {
    .chatbox-message-wrapper {
        width: calc(100vw - 2rem);
    }
    .chatbox-wrapper {
        bottom: 1rem;
        right: 1rem;
    }
}
/* BREAKPOINTS */
</style>
