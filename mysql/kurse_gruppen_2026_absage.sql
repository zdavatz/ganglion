--
-- Gruppenaushaenge 2026 (Mail Sekretariat 9.9.2026): Flyer verknuepfen,
-- restliche Termine 2026 aus gesundheitlichen Gruenden abgesagt.
--
UPDATE kurse SET pdf_kurse = 'Angehoerigengruppe_2026.pdf', datum_kurse = '2026-09-09',
  daten_kurse = '19.01.2026%2C+23.02.2026%2C+23.03.2026%2C+27.04.2026%2C+18.05.2026%2C+22.06.2026%2C+24.08.2026%0ADie+Termine+21.09.2026%2C+26.10.2026%2C+23.11.2026+und+14.12.2026+sind+aus+gesundheitlichen+Gr%C3%BCnden+abgesagt.' WHERE id_kurse = 46;
UPDATE kurse SET pdf_kurse = 'Erziehungspersonen_ADHS_Gruppe_2026.pdf', datum_kurse = '2026-09-09',
  daten_kurse = '29.01.2026%2C+26.02.2026%2C+26.03.2026%2C+30.04.2026%2C+21.05.2026%2C+25.06.2026%2C+27.08.2026%0ADie+Termine+24.09.2026%2C+29.10.2026%2C+26.11.2026+und+17.12.2026+sind+aus+gesundheitlichen+Gr%C3%BCnden+abgesagt.' WHERE id_kurse = 47;
