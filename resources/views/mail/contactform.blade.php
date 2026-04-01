@component('mail::message')
# Nová zpráva z kontaktního formuláře

**Jméno:** {{ $name }}  
**Email:** {{ $email }}  
**Telefon:** {{ $phone }}

---

### Zpráva:
{{ $content }}

@endcomponent
