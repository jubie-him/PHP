document.querySelectorAll('nav button').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('main section').forEach(sec => sec.classList.remove('active'));
        document.getElementById(btn.dataset.section).classList.add('active');
    });
});

const api = path => fetch(path, { headers: { 'Content-Type': 'application/json' } });

// Register
const registerForm = document.getElementById('register-form');
registerForm.addEventListener('submit', async e => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(registerForm));
    const res = await fetch('/register', { method: 'POST', body: JSON.stringify(data) });
    const json = await res.json();
    document.getElementById('register-response').textContent = JSON.stringify(json, null, 2);
});

// Post Job
const jobForm = document.getElementById('job-form');
jobForm.addEventListener('submit', async e => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(jobForm));
    const res = await fetch('/jobs', { method: 'POST', body: JSON.stringify(data) });
    const json = await res.json();
    alert('Job created with ID ' + json.id);
    jobForm.reset();
});

// Load Jobs
const loadJobsBtn = document.getElementById('load-jobs');
loadJobsBtn.addEventListener('click', async () => {
    const res = await fetch('/jobs');
    const jobs = await res.json();
    const list = document.getElementById('job-list');
    list.innerHTML = '';
    jobs.forEach(job => {
        const li = document.createElement('li');
        li.textContent = `${job.id}: ${job.title}`;
        list.appendChild(li);
    });
});

// Apply
const applyForm = document.getElementById('apply-form');
applyForm.addEventListener('submit', async e => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(applyForm));
    const res = await fetch('/apply', { method: 'POST', body: JSON.stringify(data) });
    const json = await res.json();
    document.getElementById('apply-response').textContent = JSON.stringify(json, null, 2);
});

// Send Message
const messageForm = document.getElementById('message-form');
messageForm.addEventListener('submit', async e => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(messageForm));
    const res = await fetch('/messages', { method: 'POST', body: JSON.stringify(data) });
    const json = await res.json();
    alert('Message sent with ID ' + json.id);
    messageForm.reset();
});

// Load Messages
const loadMessagesBtn = document.getElementById('load-messages');
loadMessagesBtn.addEventListener('click', async () => {
    const userId = document.getElementById('inbox-user').value;
    const res = await fetch('/messages?user_id=' + encodeURIComponent(userId));
    const messages = await res.json();
    const list = document.getElementById('message-list');
    list.innerHTML = '';
    messages.forEach(msg => {
        const li = document.createElement('li');
        li.textContent = `${msg.sender_id} -> ${msg.receiver_id}: ${msg.content}`;
        list.appendChild(li);
    });
});
