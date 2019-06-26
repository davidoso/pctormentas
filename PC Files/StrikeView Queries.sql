USE ALERTATORMENTAS;

CREATE SCHEMA strikeview;					--Esquema temporal en BD SIGEPRO

SELECT CONVERT(VARCHAR(),GETDATE(),114);	--Formato HH:MM:SS:MMM

UPDATE [strikeview].[t_mode] SET _stop = null WHERE mode_id > 750;

--Tabla 1/2
CREATE TABLE strikeview.ct_origin(
	id_origin				int				identity(1,1),
	origin					varchar(50)		not null,

	CONSTRAINT pk_ct_origin PRIMARY KEY(id_origin)
)
GO
INSERT INTO strikeview.ct_origin VALUES
('MINA'),
('MANZANILLO'),
('PRESAS');

--Tabla 2/2
CREATE TABLE strikeview.t_mode(
	mode_id					int,			--mode_id original de StrikeViewData.sqlite
	_start					datetime,
	_stop					datetime,
	mode					tinyint,
	duration				float,
	id_origin				int,

	CONSTRAINT pk_mode PRIMARY KEY(mode_id),
	CONSTRAINT fk_mode_id_origin FOREIGN KEY (id_origin) REFERENCES strikeview.ct_origin(id_origin)
)

INSERT INTO strikeview.t_mode VALUES
('759', '2017-07-16 15:12:33', '2017-07-16 18:09:52', '3', '10639.2160000801', 1),
('760', '2017-07-16 15:17:33', '2017-07-16 16:48:19', '2', '5445.81500005722', 1),
('761', '2017-07-16 15:17:33', '2017-07-16 16:39:39', '1', '4925.92700004578', 2);

SELECT TOP(1)
	mode_id,
	mode,
	_start AS 'start_time',
	CONVERT(VARCHAR(8), _start, 3) + ' a las ' + CONVERT(VARCHAR(5), _start, 8) AS 'format_start_time',
	DATEDIFF(minute, _start, GETDATE()) AS 'current_minute_diff', GETDATE() AS 'current_date'
FROM strikeview.t_mode
WHERE _stop IS NULL AND id_origin = 1
ORDER BY mode_id DESC;

SELECT TOP(1)
	mode_id,
	mode,
	CONVERT(VARCHAR(8), _start, 3) + ' a las ' + CONVERT(VARCHAR(5), _start, 8) AS 'format_start_time',
	_stop
FROM strikeview.t_mode
WHERE id_origin = 1
ORDER BY mode_id DESC;