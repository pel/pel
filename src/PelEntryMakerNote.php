<?php

namespace lsolesen\pel;

/**
 * Class used to hold data for MakerNote tags.
 */
class PelEntryMakerNote extends PelEntryUndefined
{
    /**
     * The offset of the MakerNote IFD vs the main DataWindow.
     *
     * @var int
     */
    protected $dataOffset;

    /**
     * Constructs a PelEntry that can hold MakerNote data.
     *
     * @param integer $tag
     *            the MakerNote TAG id.
     * @param string $data
     *            the MakerNote data.
     * @param integer $data_offset
     *            the offset of the MakerNote IFD vs the main DataWindow.
     */
    public function __construct($tag, $data, $data_offset)
    {
        parent::__construct($tag, $data);
        $this->setDataOffset($data_offset);
    }

    /**
     * Get arguments for the instance constructor from file data.
     *
     * @param int $ifd_id
     *            the IFD id.
     * @param int $tag_id
     *            the TAG id.
     * @param int $format
     *            the format of the entry as defined in {@link PelFormat}.
     * @param int $components
     *            the components in the entry.
     * @param PelDataWindow $data
     *            the data which will be used to construct the entry.
     * @param int $data_offset
     *            the offset of the main DataWindow where data is stored.
     *
     * @return array a list or arguments to be passed to the PelEntry subclass
     *            constructor.
     */
    public static function getInstanceArgumentsFromData($ifd_id, $tag_id, $format, $components, PelDataWindow $data, $data_offset)
    {
        return [$data->getBytes(), $data_offset];
    }

    /**
     * Set the offset of the MakerNote IFD vs the main DataWindow.
     *
     * @param int $data_offset
     *            the offset of the main DataWindow where data is stored.
     */
    public function setDataOffset($data_offset)
    {
        $this->dataOffset = $data_offset;
    }

    /**
     * Get the offset of the MakerNote IFD vs the main DataWindow.
     *
     * @return int
     */
    public function getDataOffset()
    {
        return $this->dataOffset;
    }

    /**
     * Get the value of this entry as text.
     *
     * The value will be returned in a format suitable for presentation.
     *
     * @param
     *            boolean some values can be returned in a long or more
     *            brief form, and this parameter controls that.
     *
     * @return string the value as text.
     */
    public function getText($brief = false)
    {
        return $this->components . ' bytes unknown MakerNote data';
    }

    /**
     * Converts a maker note tag to an IFD structure for dumping.
     *
     * @param PelDataWindow $d
     *            the data window that will provide the data.
     * @param PelIfd $ifd
     *            the root PelIfd object.
     */
    public static function tagToIfd(PelDataWindow $d, PelIfd $ifd)
    {
        // Get the Exif subIfd if existing.
        if (!$exif_ifd = $ifd->getSubIfd(PelSpec::getIfdIdByType('Exif'))) {
            return;
        }

        // Get MakerNotes from Exif IFD.
        if (!$maker_note = $exif_ifd->getEntry(PelSpec::getTagIdByName($exif_ifd->getType(), 'MakerNote'))) {
            return;
        }

        // Get Make tag from IFD0.
        if (!$make = $ifd->getEntry(PelSpec::getTagIdByName($ifd->getType(), 'Make'))) {
            return;
        }

        // Get Model tag from IFD0.
        $model_entry = $ifd->getEntry(PelSpec::getTagIdByName($ifd->getType(), 'Model'));
        $model = $model_entry ? $model_entry->getValue() : 'na';

        // Get maker note IFD id.
        if (!$maker_note_ifd_id = PelSpec::getMakerNoteIfd($make->getValue(), $model)) {
            return;
        }

        // Load maker note into IFD.
        $ifd_class = PelSpec::getIfdClass($maker_note_ifd_id);
        $ifd = new $ifd_class($maker_note_ifd_id);
        $ifd->load($d, $maker_note->getDataOffset());
        $exif_ifd->addSubIfd($ifd);
        $exif_ifd->offsetUnset(PelSpec::getTagIdByName($exif_ifd->getType(), 'MakerNote'));
    }
}
