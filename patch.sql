alter table vortrag add audiofile_length tinytext after audiofile;
alter table vortrag add audiofile_downloads int(20) unsigned DEFAULT 0 after audiofile_length;
