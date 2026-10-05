# Owner actions before request intake

The informational site can be reviewed and staged with `LEAD_ENABLED=0`, the default release setting.

Before enabling intake:

- Verify the legal operator, recipient name and monitored delivery destination. Supply a verified public contact for privacy and security reports.
- Complete privacy/terms with legal identity, processing providers, CRM retention/deletion and a rights contact. Obtain local legal review where needed; no regulatory compliance is claimed.
- Configure private `.env` with the verified identity and mail/HTTPS CRM destination. The software gate checks configuration presence, not ownership or deliverability.
- Test delivery in staging using synthetic data and mocks/test recipients. Verify SMTP/mail, CRM status monitoring, retry responsibilities and access controls.
- Configure daily `php /absolute/private/path/bin/purge-leads.php`, and separately define retention for CRM, email, backups and operational logs. Local CSV cleanup does not delete those copies.
- Verify specialists' identity, authority and availability before publishing profiles or sharing contact details. No verified providers were published during this review.
- Review inherited technical guides; existing “Revisión técnica pendiente” labels remain until a qualified reviewer approves them.
- Back up the actual Hostinger files, configuration and private storage. Reconcile this recovered-content implementation against that source before production replacement.

Then deliberately set `LEAD_ENABLED=1`. Do not describe the platform as a SOC, incident-response team or direct technical service provider. Keep `GA4_ID` empty unless privacy/consent for the actual deployment has been reviewed.

Renew `security.txt` before 2027-03-29 and use a verified monitored reporting channel when available. DNS, mail authentication, live TLS and hosting account settings were not modified.
