--
-- Spezieller Kurs "Weiterbildungskurs im Umgang mit ADHS- und ADS-Kindern und
-- Jugendlichen" (Flyer educational_engineering_2.pdf) inkl. neuem PDF-Feld.
--

ALTER TABLE kurse ADD COLUMN pdf_kurse tinytext AFTER kurs_art;

INSERT INTO kurse
  (titel_kurse, kursziele_kurse, ort_kurse, kosten_kurse,
   Arbeit, Erziehung, Gesundheit, Familie, thema_id,
   datum_kurse, beginn_kurse, ende_kurse, daten_kurse,
   leitung_kurse, platz_kurse, teilnehmer_kurse, kurs_art, pdf_kurse)
VALUES
  ('Weiterbildungskurs+im+Umgang+mit+ADHS-+und+ADS-Kindern+und+Jugendlichen',
   'Educational+Engineering+%E2%80%93+Erziehung+ist+Konstruktionsarbeit.%0A%0AKursziel%3A+Sie+lernen+den+kompetenten+Umgang+mit+neurodiversen+Kindern+und+Jugendlichen%2C+damit+eine+Folgest%C3%B6rung+m%C3%B6glichst+verhindert+werden+kann.+Statt+Schuldige+zu+suchen%2C+verstehen+wir+die+Kr%C3%A4fte+im+System+aus+Kind%2C+Familie+und+Schule%2C+ordnen+sie+ein+und+vermitteln+zwischen+den+unterschiedlichen+Gesichtspunkten.%0A%0AKursablauf%3A+Zu+Beginn+jedes+Kurstages+gibt+es+einen+theoretischen+Input+der+Kursleiterin%2C+gefolgt+von+der+praktischen+Anwendung+anhand+von+Fallbeispielen+und+Diskussionen+%C3%BCber+L%C3%B6sungsans%C3%A4tze.+Die+Themen+umfassen%3A%0A%0A-+Einf%C3%BChrung+in+ADHS%2C+ADS+und+ASS+sowie+pers%C3%B6nliche+Erziehungserfahrungen.%0A-+Konflikte+im+Umgang+mit+betroffenen+Kindern+und+L%C3%B6sungsstrategien+%28Do%E2%80%99s+and+Don%E2%80%99ts%29.%0A-+Gruppendynamik+und+Konfliktl%C3%B6sung+im+Klassenzimmer+und+auf+dem+Pausenplatz.%0A-+Umgang+mit+Eltern+von+ADHS-%2C+ADS-+und+ASS-Kindern.%0A-+Herausforderungen+der+integrativen+Schule+mit+betroffenen+Kindern.%0A-+Vorbeugung+von+Folgekrankheiten+durch+angemessenen+Umgang+mit+neurodiversen+Kindern.%0A%0AF%C3%BCr+wen%3A+Staatliche+Erziehungspersonen+wie+Lehrer%2Finnen%2C+Kinderg%C3%A4rtner%2Finnen+und+Hortleiter%2Finnen.%0A%0AAnmeldung%3A+sekretariat%40ganglion.ch',
   'Psychiatrische+Praxis+Dr.+med.+Ursula+Davatz%2C+Winterthurerstrasse+52%2C+8006+Z%C3%BCrich',
   'CHF+1%E2%80%99200.00+pro+Person+%286+Daten%29.+Durchf%C3%BChrung+ab+6+Personen%2C+max.+12+Teilnehmer.',
   1, 1, 1, 1, 22,
   '2026-08-19', '2026-08-26', '2027-05-19',
   '26.08.2026%2C+23.09.2026%2C+21.10.2026%2C+25.11.2026%2C+24.03.2027%2C+19.05.2027',
   'Frau+Dr.+med.+Ursula+Davatz%2C+Fach%C3%A4rztin+FMH+f%C3%BCr+Psychiatrie+und+Psychotherapie%2C+Familientherapeutin+nach+Murray+Bowen',
   'Jeweils 14.00 – 18.00 Uhr',
   '12',
   'spezkurse',
   'educational_engineering_2.pdf');
